<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Hash;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserProfileController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function index(Request $request)
  {
      $user = Auth::user();
      //echo $user->password;

      $rules = [
               'field2' => 'email'
           ];

           $data = [
               'field1' => 1,
               'field2' => 2
           ];

           $v = Validator::make($data, $rules);

      print_r( $v->passes());
      return view('admin.userprofile');
  }
}
