<?php

namespace App\Http\Controllers\frontend;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User;
use App\Http\Controllers\Controller;
use App\ProductCategory;
use App\Iwantto;

class SearchController extends Controller
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
        $category = $request->input('category');
        $search = $request->input('search');
        $province= $request->input('province');
        $price = $request->input('price');
        $volumn = $request->input('volumn');
        $productCategoryitem = ProductCategory::orderBy('sequence','ASC')
                    ->get();

        $Iwanttoobj = new Iwantto();
        $itemssale = $Iwanttoobj->GetSearchIwantto('sale',$category, $search, '', $province, $price, $volumn);
        $itemsbuy = $Iwanttoobj->GetSearchIwantto('buy',$category, $search, '', $province, $price, $volumn);
        return view('frontend.result',compact('productCategoryitem','itemssale', 'itemsbuy'));
    }

	public static function get_product_name($products_id)
	{
		$product_name = Product::where('id', '=', $products_id)->select('product_name_th')->value('product_name_th');
		return $product_name;
	}
}
