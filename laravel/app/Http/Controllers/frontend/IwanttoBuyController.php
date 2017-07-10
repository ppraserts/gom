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

class IwanttoBuyController extends Controller
{
  public function __construct()
  {
      $this->middleware('user');
  }

  public function index(Request $request)
  {
      $item = auth()->guard('user')->user();

      if($item->iwanttobuy != 'buy' )
      {
        return redirect()->action('frontend\UserProfileController@index');
      }

      $productCategoryitem = ProductCategory::orderBy('sequence','ASC')
                      ->get();

      $search = \Request::get('search');
      $category = \Request::get('category');

      $query = ProductRequest::where('users_id', $item->id)
                      ->where('iwantto', 'buy');
      $query = $query->join('products', 'product_requests.products_id', '=', 'products.id');
      if($category != "")
        $query = $query->where('productcategorys_id', $category);

      if($search != "")
      {
              if(is_numeric($search))
              {
                  $query = $query->where(function($query) use($search) {
                                                        return $query->where('pricerange_start', '<=', $search)
                                                                                ->where('pricerange_end', '>=', $search);
                                                    })
                                              ->orWhere(function($query) use($search) {
                                                        return $query->where('volumnrange_start', '<=', $search)
                                                                                ->where('volumnrange_end', '>=', $search);
                                                    });
              }
              else {
                     $query = $query->Where('product_title','like','%'.$search.'%')
                                              ->orWhere('units','like','%'.$search.'%')
                                              ->orWhere('city','like','%'.$search.'%')
                                              ->orWhere('province','like','%'.$search.'%')
											  ->orWhere('product_name_th','like','%'.$search.'%');
              }

      }



      $items = $query->orderBy('product_requests.created_at','desc')
                     ->paginate(12);
                     //dd($items);


      return view('frontend.iwanttobuy',compact('items','productCategoryitem'))
          ->with('i', ($request->input('page', 1) - 1) * config('app.paginate'));
  }
}
