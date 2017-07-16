<?php

namespace App\Http\Controllers\frontend;

use App\Market;
use Auth,DB,Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User;
use App\Http\Controllers\Controller;
use App\ProductCategory;
use App\ProductRequest;

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
        $markets = Market::all();
        $selected_markets = Input::get('markets');
        $productCategoryitem = ProductCategory::orderBy('sequence','ASC')
                    ->get();

        if (is_array($selected_markets)){
            for ($i = 0; $i < $markets->count(); $i++) {
                $markets[$i]->checked = false;
                foreach ($selected_markets as $selected_market) {
                    if ($markets[$i]->id == $selected_market) {
                        $markets[$i]->checked = true;
                    }
                }
            }
        }

        $productRequest = new ProductRequest();
        $itemssale = $productRequest->GetSearchProductRequests('sale',$category, $search, '', $province, $price, $volumn,$selected_markets);
        $itemsbuy = $productRequest->GetSearchProductRequests('buy',$category, $search, '', $province, $price, $volumn);
//        return $itemssale;

        return view('frontend.result',compact('productCategoryitem','itemssale', 'itemsbuy','markets','selected_markets'));
    }

	public static function get_product_name($products_id)
	{
		$product_name = Product::where('id', '=', $products_id)->select('product_name_th')->value('product_name_th');
		return $product_name;
	}

	public function unsubscribe(Request $request){
        $uemail = $request->input('uemail');

        $key = $request->input('key');
        if(!empty($uemail) and md5($uemail) == $key){
            DB::table('users')
                ->where('email', $uemail)
                ->update(['requset_email_system' => 0]);
            return view('frontend.promotion_element.redirect_unsubscribe');
            //return redirect('result');
        }
        return view('errors.404');
    }
}
