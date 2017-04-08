<?php
use App\Product;
use App\Iwantto;
use App\Amphur;
use App\Province;
use App\District;
use Illuminate\Support\Facades\Input;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::group(['middleware' => ['guest']], function () {
    //Route::get('/', 'HomeController@index');
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index1');
    Route::get('/choosemarket', 'HomeController@index2');
    Route::get('/choosecategory', 'HomeController@index3');
    Route::get('/advancesearch', 'HomeController@index4');
    Route::get('/news', 'frontend\NewsController@index');
    Route::get('/news/{id}', 'frontend\NewsController@edit');
    Route::resource('/contactus','ContactusController');
    Route::get('/faq', 'FaqController@index');
    Route::get('/sitemap', 'frontend\SitemapController@index');
    Route::get('/result', 'frontend\SearchController@index');
    Route::get('/market', 'frontend\MarketController@index');

    Route::get('/clear-cache', function() {
        $exitCode = Artisan::call('cache:clear');
        return Redirect::back();
    });

    Route::get('change/{locale}', function ($locale) {
    	Session::set('locale', $locale); // กำหนดค่าตัวแปรแบบ locale session ให้มีค่าเท่ากับตัวแปรที่ส่งเข้ามา
    	return Redirect::back(); // สั่งให้โหลดหน้าเดิม
    });

    Route::get('/information/create/ajax-state',function()
    {
        $productcategorys_id = Input::get('productcategorys_id');
		$product_name_th = Input::get('product_name_th');
        if($product_name_th != "")
        {
			if($productcategorys_id != '')
			{
	            $subcategories = Product::where('productcategory_id','=',$productcategorys_id)->where('product_name_th','like','%'.$product_name_th.'%')->limit(10)->get();
			}
			else
			{
				$subcategories = Product::where('product_name_th','like','%'.$product_name_th.'%')->limit(10)->get();
			}
        }

        $province_id = Input::get('province_id');
        if($province_id != "")
        {
            $province = Province::where('PROVINCE_NAME','=',$province_id)->get();
            $subcategories = Amphur::where('PROVINCE_ID','=',$province[0]->PROVINCE_ID)->get();
        }

        $city_id = Input::get('city_id');
        if($city_id != "")
        {
            $city = Amphur::where('AMPHUR_NAME','=',$city_id)->get();
            $subcategories = District::where('AMPHUR_ID','=',$city[0]->AMPHUR_ID)->get();
        }

        $search = Input::get('query');
        if($search != "")
        {
            $subcategories = Product::where('product_name_th','like','%'.$search.'%')
                              ->select('id','product_name_th as name')
                              ->get();
        }
        return $subcategories;

    });


    // ADMIN
    Route::get('admin/login', 'backend\Auth\LoginController@getLoginForm');
    Route::post('admin/authenticate', 'backend\Auth\LoginController@authenticate');

    //Route::get('admin/register', 'backend\Auth\RegisterController@getRegisterForm');
    //Route::post('admin/saveregister', 'backend\Auth\RegisterController@saveRegisterForm');

    // USER
    Route::get('user/login', 'frontend\Auth\LoginController@getLoginForm');
    Route::post('user/authenticate', 'frontend\Auth\LoginController@authenticate');

    Route::get('user/chooseregister', 'frontend\Auth\RegisterController@getChooseRegisterForm');
    Route::get('user/register', 'frontend\Auth\RegisterController@getRegisterForm');
    Route::post('user/saveregister', 'frontend\Auth\RegisterController@saveRegisterForm');

    Route::get('user/companyregister', 'frontend\Auth\RegisterController@getCompanyRegisterForm');
    Route::post('user/savecompanyregister', 'frontend\Auth\RegisterController@saveCompanyRegisterForm');

    // Password Reset Routes...
    Route::get('user/password/reset', 'frontend\Auth\ForgotPasswordController@showLinkRequestForm');
    Route::post('user/password/email', 'frontend\Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('user/password/reset/{token}', 'frontend\Auth\ResetPasswordController@showResetForm');
    Route::get('password/reset/{token}', 'frontend\Auth\ResetPasswordController@showResetForm');
    Route::post('user/password/reset', 'frontend\Auth\ResetPasswordController@reset');
});

Route::group(['prefix' => 'user','middleware' => ['user']], function () {
    Route::post('logout', 'frontend\Auth\LoginController@getLogout');
    //Route::get('user/dashboard', 'frontend\UserController@dashboard');

    /*Route::get('user/userprofile/', function () {
        return view('frontend.userprofile');
    });*/
    Route::resource('userprofiles','frontend\UserProfileController');
    Route::post('updateprofiles', 'frontend\UserProfileController@updateProfile');

    Route::resource('changepasswords','frontend\ChangePasswordController');
    Route::post('updatepasswords', 'frontend\ChangePasswordController@updatePassword');

    Route::resource('inboxmessage','frontend\InboxMessageController');
    Route::resource('iwanttobuy','frontend\IwanttoBuyController');
    Route::resource('iwanttosale','frontend\IwanttoSaleController');
    Route::resource('matchings','frontend\MatchingController');
    Route::resource('productsaleedit','frontend\ProductsSaleEditController');
    Route::resource('productbuyedit','frontend\ProductsBuyEditController');
    Route::resource('productview','frontend\ProductsViewController');

    Route::resource('shopsetting','frontend\ShopSettingController');
//    Route::resource('shoppingcart','frontend\ShoppingCartController');
    Route::get('settheme/{theme}', 'frontend\ShopSettingController@setTheme');
    Route::post('shoppingcart/addToCart', 'frontend\ShoppingCartController@addToCart');

    Route::get('/information/removeproduct/ajax-state',function()
    {
        $stateid = Input::get('stateid');
        $Iwantto = Iwantto::find($stateid);
        $Iwantto->delete();
        return [];

    });
    Route::get('userproduct/all','frontend\ProductController@all');
    Route::resource('userproduct','frontend\ProductController');
    Route::get('promotion/index','frontend\PromotionsController@index');
    Route::resource('promotion','frontend\PromotionsController');

});

Route::group(['prefix' => 'admin','middleware' => ['admin']], function () {
    //Route::get('dashboard', 'backend\AdminController@dashboard');
    Route::post('logout', 'backend\Auth\LoginController@getLogout');
    Route::get('/', 'backend\UserProfileController@index');
    Route::resource('userprofile','backend\UserProfileController');
    Route::resource('productcategory','backend\ProductCategoryController');
    Route::resource('slideimage','backend\SlideImageController');
    Route::resource('downloaddocument','backend\DownloadDocumentController');
    Route::resource('aboutus','backend\AboutUsController');
    Route::resource('contactus','backend\ContactUsController');
    Route::resource('contactusform','backend\ContactUsFormController');
    Route::resource('faqcategory','backend\FaqCategoryController');
    Route::resource('faq','backend\FaqController');
    Route::resource('product','backend\ProductController');
    Route::resource('media','backend\MediaController');
    Route::resource('changepassword','backend\ChangePasswordController');
    Route::resource('market','backend\MarketController');
    Route::resource('users','backend\UsersController');
    Route::resource('companys','backend\CompanysController');
    Route::resource('news','backend\NewsController');
    Route::resource('reportuser','backend\ReportController');
    Route::resource('adminteam','backend\AdminteamController');
});

Route::group(['prefix' => 'shop','middleware' => ['user']], function () {
    Route::resource('shop/shoppingcart','frontend\ShoppingCartController');
    Route::post('shoppingcart/checkout', 'frontend\ShoppingCartController@checkout');
});

Route::group(['prefix' => '{shop}', 'middleware' => ['user' , 'shop']], function () {

    Route::get('/', function ($shop)    {
        $shop_name = session('shop')['shop_name'] ;
        if(trim( strtolower($shop_name) == trim(strtolower($shop)))  ){
            return redirect($shop.'');
        }
        return abort(404);
    });

    Route::resource('/', 'frontend\ShopIndexController@index');
});


