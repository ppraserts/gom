<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User;
use App\Http\Controllers\Controller;
use App\AboutUs;
use App\SlideImage;
use App\Media;
use App\ProductCategory;

class HomeController extends Controller
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
        //echo Hash::check('12345', $user->password);
        //echo $user = auth()->authenticate();
        //echo auth()->user()->password;
        $aboutusItem = AboutUs::find(1);
        $bannerItem = SlideImage::where('slideimage_type','=','B')
                    ->orderBy('slideimage_type','ASC')
                    ->orderBy('sequence','ASC')
                    ->get();

        $slideItem = SlideImage::where('slideimage_type','=','AS')
                    ->orderBy('slideimage_type','ASC')
                    ->orderBy('sequence','ASC')
                    ->get();

        $mediaItem = Media::orderBy('sequence','ASC')
                    ->get();

        $productCategoryitem = ProductCategory::orderBy('sequence','ASC')
                    ->get();

        return view('welcome',compact('aboutusItem'
                                        ,'bannerItem'
                                        ,'slideItem'
                                        ,'mediaItem'
                                        ,'productCategoryitem'));
    }
}