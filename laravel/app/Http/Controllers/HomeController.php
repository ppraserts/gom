<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User;
use App\Http\Controllers\Controller;
use App\AboutUs;
use App\SlideImage;
use App\Media;
use App\ProductCategory;
use App\Market;
use App\Contactus;
use App\ContactUsForm;
use App\Province;

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

         $marketItem = Market::orderBy('sequence','ASC')
                    ->get();

        return view('choosemarket',compact('aboutusItem'
                                        ,'bannerItem'
                                        ,'slideItem'
                                        ,'mediaItem'
                                        ,'productCategoryitem'
                                        ,'marketItem'));
    }

    public function index2(Request $request)
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

         $marketItem = Market::orderBy('sequence','ASC')
                    ->get();

        return view('welcome',compact('aboutusItem'
                                        ,'bannerItem'
                                        ,'slideItem'
                                        ,'mediaItem'
                                        ,'productCategoryitem'
                                        ,'marketItem'));
    }

    public function index3(Request $request)
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

         $marketItem = Market::orderBy('sequence','ASC')
                    ->get();

        return view('category',compact('aboutusItem'
                                        ,'bannerItem'
                                        ,'slideItem'
                                        ,'mediaItem'
                                        ,'productCategoryitem'
                                        ,'marketItem'));
    }

    public function index4(Request $request)
    {
        //echo Hash::check('12345', $user->password);
        //echo $user = auth()->authenticate();
        //echo auth()->user()->password;
        $provinceItem = Province::orderBy('PROVINCE_NAME','ASC')
                    ->get();

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

         $marketItem = Market::orderBy('sequence','ASC')
                    ->get();

        return view('advancesearch',compact('aboutusItem'
                                        ,'bannerItem'
                                        ,'slideItem'
                                        ,'mediaItem'
                                        ,'productCategoryitem'
                                        ,'marketItem'
                                        ,'provinceItem'));
    }
}
