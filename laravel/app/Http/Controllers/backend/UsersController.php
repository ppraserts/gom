<?php

namespace App\Http\Controllers\backend;

use File;
use Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\frontend\User;

class UsersController extends Controller
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
                                            $query->where('users_membertype','=', 'personal');
                                    })->where(function($query) use ($search) {
                                            $query->where('users_firstname_th','like','%'.$search.'%')
                                                  ->orWhere('users_lastname_th','like','%'.$search.'%')
                                                  ->orWhere('users_firstname_en','like','%'.$search.'%')
                                                  ->orWhere('users_lastname_en','like','%'.$search.'%')
                                                  ->orWhere('email','like','%'.$search.'%');
                                    })->orderBy('is_active', 'asc')
                                       ->orderBy('created_at','DESC')
                                       ->paginate(config('app.paginate'));

        return view('backend.usersindex',compact('items','countinactiveusers','countinactivecompanyusers'))
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
        return view('backend.usersedit',compact('item','countinactiveusers','countinactivecompanyusers'))->with($data);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $is_active = $user->is_active;
        $user->is_active = $request->is_active == "" ? 0 : 1;
        $user->update();

        if(($is_active==0) && ($user->is_active == 1))
        {
                $sendemailTo = $user->email;
                $sendemailFrom = env('MAIL_USERNAME');

                $data = array(
                    'fullname' => $user->users_membertype == "personal"?  $user->users_firstname_th." ".$user->users_lastname_th : $user->users_company_th
                );
                Mail::send('emails.confirmregister', $data, function ($message) use($request, $sendemailTo, $sendemailFrom)
                {
                    $message->from($sendemailFrom
                            , "Greenmart Online Market");
                    $message->to($sendemailTo)
                            ->subject("Greenmart Online Market : ".trans('messages.email_subject_newregister'));

                });
        }

        return redirect()->route('users.index')
                        ->with('success',trans('messages.message_update_success'));
    }

    public function destroy($id)
    {
        $deleteItem = User::find($id);
        $deleteItem->delete();
        return redirect()->route('users.index')
                        ->with('success',trans('messages.message_delete_success'));
    }
}
