<?php

namespace App\Http\Controllers\backend;

use App\Market;
use App\UserMarket;
use App\Standard;
use App\Province;
use App\District;
use App\Amphur;
use App\UserStandard;
use File, Mail;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\frontend\User;

class CompanysController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $search = \Request::get('search');
        $countinactiveusers = User::where(function ($query) {
            $query->where('users_membertype', '=', 'personal')
                ->where('is_active', '=', 0);
        })->count();

        $countinactivecompanyusers = User::where(function ($query) {
            $query->where('users_membertype', '=', 'company')
                ->where('is_active', '=', 0);
        })->count();

        $items = User::where(function ($query) {
            $query->where('users_membertype', 'company');
        })->where(function ($query) use ($search) {
            $query->where('users_company_th', 'like', '%' . $search . '%')
                ->orWhere('users_company_en', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        })->orderBy('is_active', 'asc')
            ->orderBy('created_at', 'DESC')
            ->paginate(config('app.paginate'));
        return view('backend.companysindex', compact('items', 'countinactiveusers', 'countinactivecompanyusers'))
            ->with('i', ($request->input('page', 1) - 1) * config('app.paginate'));
    }

    public function edit($id)
    {
        $countinactiveusers = User::where(function ($query) {
            $query->where('users_membertype', '=', 'personal')
                ->where('is_active', '=', 0);
        })->count();

        $countinactivecompanyusers = User::where(function ($query) {
            $query->where('users_membertype', '=', 'company')
                ->where('is_active', '=', 0);
        })->count();
        $standards = Standard::join('user_standard', 'user_standard.standard_id', '=', 'standards.id')
            ->where('user_standard.user_id', $id)->get();
        $standard = null;
        if ($standards != null) {
            $standardArr = array();
            foreach ($standards as $item) {
                array_push($standardArr, $item->standard_id);
            }
            //$standard = implode(", ", $standardArr);
            $standard = $standardArr;
        }
        $data = array('mode' => 'edit');
        $item = User::find($id);

        $markets = Market::all();
        $userMarkets = UserMarket::where('user_id', $id)->get();

        for ($i = 0; $i < $markets->count(); $i++) {
            $markets[$i]->checked = false;
            foreach ($userMarkets as $userMarket) {
                if ($markets[$i]->id == $userMarket->market_id) {
                    $markets[$i]->checked = true;
                }
            }
        }
        //return $standard;
        $provinceItem = Province::all();
        $amphurs = Amphur::where('AMPHUR_NAME',$item->users_city)->get();
        $districts =District::where('DISTRICT_NAME',$item->users_district)->get();
        $standard_all = Standard::all();

        return view('backend.companysedit',
            compact('item', 'countinactiveusers',
                'countinactivecompanyusers',
                'standard', 'markets',
                'provinceItem','amphurs','districts','standard_all'
            ))
            ->with($data);
    }

    public function update(Request $request, $id)
    {
        //return $request->all();
        $user = User::find($id);
        $user_id = $user->id;
        $is_active = $user->is_active;
        $arr_checked_user_standards =  $request->input('standard');

        $user->is_active = $request->is_active == "" ? 0 : 1;
        $user->is_active = $request->is_active == "" ? 0 : 1;
        $user->other_standard = $request->input('other_standard');
        $user->users_company_th = $request->input('users_company_th');
        $user->email = $request->input('email');
        $user->users_addressname = $request->input('users_addressname');
        $user->users_province = $request->input('users_province');
        $user->users_city = $request->input('users_city');
        $user->users_district = $request->input('users_district');
        $user->users_postcode = $request->input('users_postcode');
        $user->users_mobilephone = $request->input('users_mobilephone');
        $user->users_qrcode = $request->input('users_qrcode');
        $user->users_taxcode = $request->input('users_taxcode');
        $user->iwanttosale = $request->input('iwanttosale');
        $user->iwanttobuy = $request->input('iwanttobuy');
        $user->update();

        //UserStandard
        if (is_array($arr_checked_user_standards)) {
            $UserStandards = UserStandard::where('user_id', $user->id)->get();
            if(count($UserStandards)>0){
                UserStandard::where('user_id', $user->id)->delete();
            }
            foreach ($arr_checked_user_standards as $standard_id) {
                UserStandard::insert([
                    'user_id' => $user_id,
                    'standard_id' =>$standard_id
                ]);
            }
        }else{
            $UserStandards = UserStandard::where('user_id', $user->id)->get();
            if(count($UserStandards)>0){
                UserStandard::where('user_id', $user->id)->delete();
            }
        }

        $arr_markets = Input::get('markets');
        $userMarkets = UserMarket::where('user_id', $id)->get();
        foreach ($userMarkets as $userMarket) {
            $userMarket->delete();
        }
        if (is_array($arr_markets)) {
            foreach ($arr_markets as $item) {
                $userMarket = new UserMarket();
                $userMarket->user_id = $id;
                $userMarket->market_id = $item;
                $userMarket->save();
            }
        }

        if (($is_active == 0) && ($user->is_active == 1)) {
            $sendemailTo = $user->email;
            $sendemailFrom = env('MAIL_USERNAME');
            $data = array(
                'fullname' => $user->users_membertype == "personal" ? $user->users_firstname_th . " " . $user->users_lastname_th : $user->users_company_th
            );
            Mail::send('emails.confirmregister', $data, function ($message) use ($request, $sendemailTo, $sendemailFrom) {
                $message->from($sendemailFrom
                    , "DGTFarm");
                $message->to($sendemailTo)
                    ->subject("DGTFarm : " . trans('messages.email_subject_newregister'));
            });
        }
        //return redirect()->route('companys.index')
        //    ->with('success', trans('messages.message_update_success'));
        return redirect('admin/companys/'.$id.'/edit')->with('success', trans('messages.message_update_success'));
    }

    public function destroy($id)
    {
        $deleteItem = User::find($id);
        $deleteItem->delete();
        return redirect()->route('companys.index')
            ->with('success', trans('messages.message_delete_success'));
    }
}
