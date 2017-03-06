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
    'users_firstname_th' => 'required|max:255',
    'users_lastname_th' => 'required|max:255',
    'users_dateofbirth' => 'required|date_format:Y-m-d',
    'users_imageprofile' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3048',
  ];

  private $rulescompany = [
    'users_company_th' => 'required|max:255',
    'users_company_en' => 'required|max:255',
    'users_imageprofile' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3048',
  ];

  public function __construct()
  {
      $this->middleware('user');
  }

  public function index(Request $request)
  {
      $item = auth()->guard('user')->user();
      $provinceItem = Province::orderBy('PROVINCE_NAME','ASC')
                  ->get();



      return view('frontend.theme',compact('item','provinceItem'));
  }


}
