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

class IwanttoBuyController extends Controller
{
  public function __construct()
  {
      $this->middleware('user');
  }

  public function index(Request $request)
  {
      $item = auth()->guard('user')->user();
      if($item->iwantto == "sale" )
      {
        return redirect()->action('frontend\UserProfileController@index');
      }

      return view('frontend.iwanttobuy');
  }
}
