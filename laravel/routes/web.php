<?php

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
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index');
    Route::resource('/contactus','ContactusController');
    Route::get('/faq', 'FaqController@index');

    Route::get('/clear-cache', function() {
        $exitCode = Artisan::call('cache:clear');
        return Redirect::back();
    });

    Route::get('change/{locale}', function ($locale) {
    	Session::set('locale', $locale); // กำหนดค่าตัวแปรแบบ locale session ให้มีค่าเท่ากับตัวแปรที่ส่งเข้ามา
    	return Redirect::back(); // สั่งให้โหลดหน้าเดิม
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
    Route::resource('userprofile','frontend\UserProfileController');
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
});
