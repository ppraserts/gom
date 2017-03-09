<?php

namespace App\Http\Controllers\frontend;

use File;
use DB;
use Hash;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Model\frontend\User;
use App\Amphur;
use App\Province;
use App\District;

class ThemeController extends Controller
{
  private $rules = [
    'theme' => 'required',
  ];

  public function __construct()
  {
      $this->middleware('user');
  }

  public function index(Request $request)
  {
      return view('frontend.theme');
  }


  public function create(Request $request){
      $user = auth()->guard('user')->user();
      $user->theme = $request->theme;
      $user->update();
      return redirect('user/userprofiles');
  }


}
