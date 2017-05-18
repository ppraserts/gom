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
use App\ProductRequest;

class MatchingController extends Controller
{
  public function __construct()
  {
      $this->middleware('user');
  }

  public function index(Request $request)
  {
      $userItem = auth()->guard('user')->user();
      $productRequest = new ProductRequest();

      $orderby = $request->input('orderby');

      $itemsbuy = $productRequest->GetSaleMatchingWithBuy($userItem->id, $orderby);
      $itemssale = $productRequest->GetBuyMatchingWithSale($userItem->id, $orderby);

      return view('frontend.matching',compact('itemsbuy','itemssale','userItem'));
  }
}
