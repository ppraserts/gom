<?php

namespace App\Http\Controllers\frontend;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User;
use App\Http\Controllers\Controller;
use App\ProductCategory;
use App\ProductRequest;
use App\Market;
use App\Product;

class MarketController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $iwantto = $request->input('iwantto');
        $id = $request->input('id');
        $category = $request->input('category');
        $productCategoryitem = ProductCategory::orderBy('sequence','ASC')
                    ->get();

        $marketItem = Market::find($id);

        $qrcode = "";
        if($id == 2)
        {
          $qrcode = $id;
        }

        $productRequest = new ProductRequest();
        $itemssale = $productRequest->GetSearchProductRequests('sale',$category, '',$qrcode, '', '', '');
        $itemsbuy = $productRequest->GetSearchProductRequests('buy',$category, '',$qrcode, '', '', '');

        return view('frontend.market',compact('productCategoryitem'
                                                  ,'marketItem'
                                                  ,'itemssale'
                                                  ,'itemsbuy'));
    }

	public static function get_product_name($products_id)
	{
		$product_name = Product::where('id', '=', $products_id)->select('product_name_th')->value('product_name_th');
		return $product_name;
	}
}
