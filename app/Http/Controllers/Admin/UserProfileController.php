<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductCategory;

class UserProfileController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function index(Request $request)
  {
      return view('admin.userprofile');
  }
}
