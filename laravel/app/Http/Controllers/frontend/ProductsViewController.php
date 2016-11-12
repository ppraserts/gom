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
use App\ProductCategory;

class ProductsViewController extends Controller
{
	 public function __construct()
	  {
	      $this->middleware('user');
	  }

	  public function show($id)
	  {
	  	$item = Iwantto::find($id);
	  	$useritem = auth()->guard('user')->user();
	  	$productCategoryitem = ProductCategory::orderBy('sequence','ASC')->get();
	  	return view('frontend.productview',compact('item','useritem','productCategoryitem'));
	  }
}