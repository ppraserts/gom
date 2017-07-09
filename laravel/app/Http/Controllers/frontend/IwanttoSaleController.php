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
use App\ProductCategory;

class IwanttoSaleController extends Controller
{
  public function __construct()
  {
      $this->middleware('user');
  }

  public function index(Request $request)
  {
      $item = auth()->guard('user')->user();
      if($item->iwanttosale != 'sale' )
      {
        return redirect()->action('frontend\UserProfileController@index');
      }

      $productCategoryitem = ProductCategory::orderBy('sequence','ASC')
                  ->get();

      $search = \Request::get('search');
      $category = \Request::get('category');

      $query = ProductRequest::where('users_id', $item->id)
                      ->where('iwantto', 'sale');

      if($category != "")
        $query = $query->where('productcategorys_id', $category);

      if($search != "")
      {
        $query = $query
					  ->join('products', 'product_requests.products_id', '=', 'products.id')
					  ->where('product_title','like','%'.$search.'%')
                      ->orWhere('price','like','%'.$search.'%')
                      //->orWhere('guarantee','like','%'.$search.'%')
                      ->orWhere('volumn','like','%'.$search.'%')
                      ->orWhere('productstatus','like','%'.$search.'%')
                      ->orWhere('units','like','%'.$search.'%')
                      ->orWhere('city','like','%'.$search.'%')
                      ->orWhere('province','like','%'.$search.'%')
					  ->orWhere('product_name_th','like','%'.$search.'%');
      }

      $items = $query
          ->orderBy('product_requests.sequence','asc')
          ->orderBy('product_requests.updated_at','desc')
          ->paginate(config('app.paginate'));

      return view('frontend.iwanttosale',compact('items','productCategoryitem'))
          ->with('i', ($request->input('page', 1) - 1) * config('app.paginate'));

  }

  public function productEdit(Request $request)
  {
  }
}
