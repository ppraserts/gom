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
        $productCategoryitem = ProductCategory::orderBy('sequence','ASC')
                    ->get();

        $Iwanttoobj = new Iwantto();
        $itemssale = $Iwanttoobj->GetSearchIwantto('sale',$category, $search, '');
        $itemsbuy = $Iwanttoobj->GetSearchIwantto('buy',$category, $search, '');
        return view('frontend.result',compact('productCategoryitem','itemssale', 'itemsbuy'));
    }
}
