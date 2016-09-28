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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return Redirect::back();
});

Route::get('change/{locale}', function ($locale) {
	Session::set('locale', $locale); // กำหนดค่าตัวแปรแบบ locale session ให้มีค่าเท่ากับตัวแปรที่ส่งเข้ามา
	return Redirect::back(); // สั่งให้โหลดหน้าเดิม
});

Auth::routes();
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'HomeController@index');
    Route::get('home', 'HomeController@index');
    Route::resource('userprofile','Admin\UserProfileController');
    Route::resource('productcategory','Admin\ProductCategoryController');
    Route::resource('slideimage','Admin\SlideImageController');
    Route::resource('downloaddocument','Admin\DownloadDocumentController');
    Route::resource('aboutus','Admin\AboutUsController');
    Route::resource('contactus','Admin\ContactUsController');
});
