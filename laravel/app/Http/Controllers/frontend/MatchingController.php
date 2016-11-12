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
use App\Iwantto;

class MatchingController extends Controller
{
  public function __construct()
  {
      $this->middleware('user');
  }

  public function index(Request $request)
  {
      $userItem = auth()->guard('user')->user();
      $Iwanttoobj = new Iwantto();

      if($userItem->iwantto == "buy")
      	$items = $Iwanttoobj->GetSaleMatchingWithBuy($userItem->id);
      else
      	$items = $Iwanttoobj->GetBuyMatchingWithSale($userItem->id);
      	
      return view('frontend.matching',compact('items','userItem'));
  }
}
