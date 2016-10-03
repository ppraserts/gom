<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use Hash;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserProfileController extends Controller
{
  public function __construct()
  {
      //$this->middleware('auth');
  }

  public function index(Request $request)
  {
      $item = Auth::user();
      return view('admin.userprofile',compact('item'));
  }

  public function update(Request $request)
  {
    $user = Auth::user();

    $validation = Validator::make($request->all(), [

      // Here's how our new validation rule is used.
      'users_firstname_th' => 'required',
      'users_lastname_th' => 'required',
      'users_firstname_en' => 'required',
      'users_lastname_en' => 'required',
      'email' => 'required|email',
      'users_mobilephone' => 'required',
    ]);

    if ($validation->fails()) {
      return redirect()->route('userprofile.index')->withErrors($validation->errors());
    }

    $user->users_firstname_th = $request->input('users_firstname_th');
    $user->users_lastname_th = $request->input('users_lastname_th');
    $user->users_firstname_en = $request->input('users_firstname_en');
    $user->users_lastname_en = $request->input('users_lastname_en');
    $user->email = $request->input('email');
    $user->users_mobilephone = $request->input('users_mobilephone');

    $total = DB::select(DB::raw("select count(*) as cnt
                                 from users
                                 where id <> ".$user->id."
                                 and email = '".$request->input('email')."' "));
    if($total[0]->cnt == 0){
      $user->save();

      return redirect()->route('userprofile.index')
        ->with('success', trans('messages.message_update_success'));
    }
    else {
      return redirect()->route('userprofile.index')->withErrors(trans('messages.message_email_inuse'));
    }
  }
}
