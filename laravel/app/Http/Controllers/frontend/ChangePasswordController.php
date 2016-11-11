<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Support\Facades\Auth;
use Hash;
use File;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChangePasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('user');
    }

    public function index()
    {
        return view('frontend.changepassword');
    }

    public function updatePassword(Request $request)
    {
      $user = auth()->guard('user')->user();

      $validation = Validator::make($request->all(), [

        // Here's how our new validation rule is used.
        'now_password' => 'required|hash:' . $user->password,
        'new_password' => 'required|different:now_password|same:password_confirmation',
        'password_confirmation' => 'required'
      ]);

      if ($validation->fails()) {
        return redirect()->route('changepasswords.index')->withErrors($validation->errors());
      }

      $user->password = Hash::make($request->input('new_password'));
      $user->save();

      return redirect()->route('changepasswords.index')
        ->with('success', trans('messages.message_reset_password_success'));
    }
}
