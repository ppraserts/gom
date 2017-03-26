<?php

namespace App\Http\Controllers\frontend;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User;
use App\Http\Controllers\Controller;
use App\Shop;


class ShopIndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('user');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->guard('user')->user();
        $shop = Shop::where('user_id', $user->id)->first();
        if($shop != null && $shop->theme != null && $shop->theme != ''){
            $theme = trim($shop->theme);
        }else{
            $theme = "main";
        }

        return view('frontend.index' , compact('theme' ))->with('shop' , $shop);
    }
}
