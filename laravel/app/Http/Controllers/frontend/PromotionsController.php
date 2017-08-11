<?php

namespace App\Http\Controllers\frontend;

use App\Helpers\DateFuncs;
use App\Http\Controllers\Controller;
use App\Shop;
use App\PormotionRecomment;
use Validator, Response;
use Illuminate\Http\Request;
use App\Promotions;
use File,DB;
use Image;
use Redirect, View, Session;
use Illuminate\Support\Facades\Mail;

class PromotionsController extends Controller
{

    private $rules = [
        'promotion_title' => 'required',
        'promotion_description' => 'required',
        'start_date' => 'required',
        'image_file' => 'mimes:jpeg,jpg,png,gif|max:500',
        'end_date' => 'required|after:start_date',
        'sequence' => 'required|integer',
    ];

    private $rulesUpdate = [
        'promotion_title' => 'required',
        'promotion_description' => 'required',
        'start_date' => 'required',
        'image_file' => 'mimes:jpeg,jpg,png,gif|max:500',
        'end_date' => 'required|after:start_date',
        'sequence' => 'required|integer',
    ];

    private $rules_reconment = [
        //'email' => 'required',
        //'detail' => 'required',
    ];

    /*private $ruleDate = [
        'start_date' => 'required',
        'end_date' => 'required|after:start_date',
    ];*/

    /**
     * PromotionsController constructor.
     */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->guard('user')->user();
        $shop = Shop::where('user_id', $user->id)->first();

        $items = array();
        if ($shop != null) {
            $items = Promotions::where('shop_id', $shop->id)->Where(function ($query) {
                $search = \Request::get('search');
                $query->where('promotion_title', 'like', '%' . $search . '%')
                    ->orWhere('promotion_description', 'like', '%' . $search . '%');
            })
                ->select(DB::raw('*,end_date < NOW() as expired'))
                ->orderBy('sequence', 'ASC')
                ->paginate(config('app.paginate'));
            $data = array('i' => ($request->input('page', 1) - 1) * config('app.paginate'),
                'setting_shop' => false);
            return view('frontend.promotionindex', compact('items', 'shop'))
                ->with($data);
        } else {
            $data = array('setting_shop' => true);
            return view('frontend.promotionindex', compact('items'))->with($data);;
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->guard('user')->user();
        $shop = Shop::where('user_id', $user->id)->first();
        $data = array('mode' => 'create',
            'user_id' => $user->id,
            'shop_id' => $shop->id
        );
        $item = new Promotions();
        $item->sequence = 999;
        $show_recommend = false;
        return view('frontend.promotionedit', compact('item','show_recommend'))->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request['start_date'] = DateFuncs::convertYear($request['start_date']);
        $request['end_date'] = DateFuncs::convertYear($request['end_date']);

        $validator = $this->getValidationFactory()->make($request->all(), $this->rules, [], []);
        if ($validator->fails()) {
            $request['start_date'] = DateFuncs::thai_date($request['start_date']);
            $request['end_date'] = DateFuncs::thai_date($request['end_date']);
            $this->throwValidationException($request, $validator);
        }

        $promotion = $request->all();

        if ($image_file = $request->file('image_file')) {
            $uploadImage = $this->UploadImage($request, 'image_file');
            $promotion['image_file'] = $uploadImage["image_path_filename"];
        }

        Promotions::create($promotion);
        return redirect()->route('promotion.index')
            ->with('success', trans('messages.message_create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = auth()->guard('user')->user();
        $shop = Shop::where('user_id', $user->id)->first();
        $data = array('mode' => 'edit',
            'user_id' => $user->id,
            'shop_id' => $shop->id
        );
        $item = Promotions::where('id',$id)->select(DB::raw('*,end_date < NOW() as expired'))->first();
        $promotion_recommends = PormotionRecomment::select(DB::raw('SUM(count_recommend) as sum_recommend, COUNT(email) as count_email,
        id,promotion_id,recommend_date,email,detail,created_at'))
            ->where('promotion_id',$id)
            ->groupBy('key')
            ->paginate(25);

        $send_today = PormotionRecomment::where('promotion_id',$id)
            ->whereDate('recommend_date',date('Y-m-d'))
            ->get();

        $show_recommend = (count($send_today)==0);

        return view('frontend.promotionedit', compact('item', 'shop','promotion_recommends','user','show_recommend'))->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request['start_date'] = DateFuncs::convertYear($request['start_date']);
        $request['end_date'] = DateFuncs::convertYear($request['end_date']);

        $validator = $this->getValidationFactory()->make($request->all(), $this->rulesUpdate, [], []);
        if ($validator->fails()) {
            $request['start_date'] = DateFuncs::thai_date($request['start_date']);
            $request['end_date'] = DateFuncs::thai_date($request['end_date']);
            $this->throwValidationException($request, $validator);
        }

        $promotion = $request->all();

        if ($request->file('image_file') != null && $image_file = $request->file('image_file')) {
//            $this->RemoveFolderImage($promotion['image_file']);
            $uploadImage = $this->UploadImage($request, 'image_file');
            $promotion['image_file'] = $uploadImage["image_path_filename"];
        }

        Promotions::find($id)->update($promotion);
        return redirect()->route('promotion.index')
            ->with('success', trans('messages.message_update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteItem = Promotions::find($id);

        $this->RemoveFolderImage($deleteItem->image_file);

        $deleteItem->delete();
        return redirect()->route('promotion.index')
            ->with('success', trans('messages.message_delete_success'));
    }

    public function uploadImage($request, $filename)
    {
        sleep(1);
        $image_path = $request->file($filename)->getPathname();
        $orgFilePathName = $request->{$filename}->getClientOriginalName();
        $ext = pathinfo($orgFilePathName, PATHINFO_EXTENSION);
        $image_directory = config('app.upload_promotion');
        $image_path_filename = $image_directory . time() . "." . $ext;
//        File::makeDirectory($image_directory, 0777, true, true);

        $img = Image::make($image_path);
        $img->save($image_path_filename);
        $img->destroy();

        return array('image_path_filename' => $image_path_filename);
    }


    private function RemoveFolderImage($rawfile)
    {
        sleep(1);
        if ($rawfile != "") {
            if (File::exists($rawfile)) {
                File::delete($rawfile);
            }
        }
    }

    public function recommendPromotion(Request $request, $id)
    {
        //return $user = auth()->guard('user')->user();
        $validator = $this->getValidationFactory()->make($request->all(), $this->rules_reconment, [], []);
        if ($validator->fails()) {
            Session::flash('error_recomment',trans('messages.message_update_success'));
            return Redirect::to('user/promotion/' . $id . '/edit')->withErrors($validator)->withInput();
        }
        $user = auth()->guard('user')->user();
        $promotion = Promotions::find($id);
        $shop = Shop::where('user_id', $user->id)->first();
        $detail = $request->input('detail');

//        $emailArr = $request->input('email');
//        $emails = explode(',', $emailArr); requset_email_system
       $user_requset_email_system = DB::table('users')
            ->select('users.*')
            ->where('requset_email_system', 1)
            ->where('iwanttobuy', 'buy')
            ->where('id', '!=', $user->id)
            ->get();
        if (count($user_requset_email_system) <= 0) {
            Session::flash('error_recomment',trans('messages.message_user_email_fail'));
            return Redirect::to('user/promotion/' . $id . '/edit')->withErrors($validator)->withInput();
        }

        $link = url($shop->shop_name."/promotion/".$id);
        $image_file = url($promotion->image_file);
        $key = md5($id.date('Y-m-d H:i:s'));
        foreach ($user_requset_email_system as $userVal) {
            if (!empty($userVal->email)) {
                $recomment['email'] = $userVal->email;
//                $recomment['detail'] = $detail;
                $recomment['count_recommend'] = 0;
                $recomment['recommend_date'] = date('Y-m-d');
                $recomment['promotion_id'] = $id;
                $recomment['key'] = $key;
                $last_id = PormotionRecomment::insertGetId($recomment);
                $encode_id = $key;
                $this->SendEmailPromotion($userVal->email, $shop->shop_title,$shop->shop_name, $promotion->promotion_title, $image_file, $userVal, $link, $last_id,$encode_id);

            }
        }
        Session::flash('success',trans('messages.message_update_success'));
        return redirect('user/promotion/'.$id.'/edit');
    }

    private function SendEmailPromotion($email, $shop_title, $shop_name, $promotion_title, $image_file, $user, $link,$last_id,$encode_id)
    {
        $sendemailTo = $email;
        $sendemailFrom = env('MAIL_USERNAME');

        $data = array(
            'email' => $email,
//            'detail' => $detail,
            'shop_title' => $shop_title,
            'shop_name' => $shop_name,
            'promotion_title' => $promotion_title,
            'image_file' => $image_file,
            'user_name' => $user->users_firstname_th.' '.$user->users_lastname_th,
            'users_addressname' => $user->users_addressname,
            'users_street' => $user->users_street,
            'users_district' => $user->users_district,
            'users_city' => $user->users_city,
            'users_province' => $user->users_province,
            'users_postcode' => $user->users_postcode,
            'users_mobilephone' => $user->users_mobilephone,
            'link' => $link,
            'pormotion_recomment_id' => $last_id,
            'encode_id' => $encode_id
        );

       sleep(0.1);
       Mail::send('frontend.promotion_element.email_template', $data, function ($message) use ($sendemailTo, $sendemailFrom, $promotion_title) {
            $message->from($sendemailFrom, 'DGTFarm');
            $message->to($sendemailTo)->subject(trans('messages.email_promotion_subject'));
        });
    }

}