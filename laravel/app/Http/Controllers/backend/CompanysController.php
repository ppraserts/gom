<?php

namespace App\Http\Controllers\backend;

use File;
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
        //$this->middleware('auth');
    }

    public function index(Request $request)
    {
        $search = \Request::get('search');

        $countinactiveusers = User::where(function ($query) {
                                                    $query->where('users_membertype','=', 'personal')
                                                                ->where('is_active','=', 0);
                                                })->count();

        $countinactivecompanyusers = User::where(function ($query) {
                                                    $query->where('users_membertype','=', 'company')
                                                                ->where('is_active','=', 0);
                                                })->count();

        $items = User::where(function ($query) {
                                            $query->where('users_membertype', 'company');
                                    })->where(function($query) use ($search) {
                                            $query->where('users_company_th','like','%'.$search.'%')
                                                        ->orWhere('users_company_en','like','%'.$search.'%')
                                                        ->orWhere('email','like','%'.$search.'%');
                                    })->orderBy('is_active', 'asc')
                                    ->orderBy('created_at','DESC')
                                    ->paginate(config('app.paginate'));
        return view('backend.companysindex',compact('items','countinactiveusers','countinactivecompanyusers'))
            ->with('i', ($request->input('page', 1) - 1) * config('app.paginate'));
    }

    public function edit($id)
    {
        $countinactiveusers = User::where(function ($query) {
                                                    $query->where('users_membertype','=', 'personal')
                                                                ->where('is_active','=', 0);
                                                })->count();

        $countinactivecompanyusers = User::where(function ($query) {
                                                    $query->where('users_membertype','=', 'company')
                                                                ->where('is_active','=', 0);
                                                })->count();

        $data = array('mode' => 'edit');
        $item = User::find($id);
        return view('backend.companysedit',compact('item','countinactiveusers','countinactivecompanyusers'))->with($data);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->is_active = $request->is_active == "" ? 0 : 1;
        $user->update();
        return redirect()->route('companys.index')
                        ->with('success',trans('messages.message_update_success'));
    }

    public function destroy($id)
    {
        $deleteItem = User::find($id);
        $deleteItem->delete();
        return redirect()->route('companys.index')
                        ->with('success',trans('messages.message_delete_success'));
    }
}
