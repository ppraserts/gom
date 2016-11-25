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
use App\Market;

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

        $Iwanttoobj = new Iwantto();
        $itemssale = $Iwanttoobj->GetSearchIwantto('sale',$category, '',$qrcode);
        $itemsbuy = $Iwanttoobj->GetSearchIwantto('buy',$category, '',$qrcode);

        return view('frontend.market',compact('productCategoryitem'
                                                  ,'marketItem'
                                                  ,'itemssale'
                                                  ,'itemsbuy'));
    }
}
