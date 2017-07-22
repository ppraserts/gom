<?php
use App\Product;
use App\ProductRequest;
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
    Route::resource('productview','frontend\ProductsViewController');
    Route::get('/unsubscribe', 'frontend\SearchController@unsubscribe');

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
    Route::resource('userprofiles','frontend\UserProfileController');
    Route::post('updateprofiles', 'frontend\UserProfileController@updateProfile');

    Route::resource('changepasswords','frontend\ChangePasswordController');
    Route::post('updatepasswords', 'frontend\ChangePasswordController@updatePassword');

    Route::resource('inboxmessage','frontend\InboxMessageController');
    Route::resource('iwanttobuy','frontend\IwanttoBuyController');
    Route::resource('iwanttosale','frontend\IwanttoSaleController');
    Route::resource('matchings','frontend\MatchingController');
    Route::resource('productsaleedit','frontend\ProductsSaleEditController');
    Route::post('productsaleupdate','frontend\ProductsSaleEditController@updatesale');
    Route::resource('productbuyedit','frontend\ProductsBuyEditController');
    Route::resource('productview','frontend\ProductsViewController');
    Route::post('productview/{id}/{key}', 'frontend\ProductsViewController@storeComment');
    Route::post('productview-update-status/{id}/', 'frontend\ProductsViewController@updateCommentStatus');
    //Shop
    Route::resource('shopsetting','frontend\ShopSettingController');
    Route::resource('shoppingcart','frontend\ShoppingCartController');
    Route::get('settheme/{theme}', 'frontend\ShopSettingController@setTheme');
    Route::get('checkshopname/{name}', 'frontend\ShopSettingController@checkShopName');
    Route::post('shoppingcart/addToCart', 'frontend\ShoppingCartController@addToCart');
    Route::post('shoppingcart/checkout', 'frontend\ShoppingCartController@checkout');
    Route::get('shoppingcart/deleteCartItem/{user_id}/{product_request_id}', ['as' => 'shoppingcart.deleteCartItem', 'uses' => 'frontend\ShoppingCartController@deleteCartItem']);
    Route::get('shoppingcart/incrementQuantityCartItem/{user_id}/{product_request_id}/{unit_price}/{is_added}', ['as' => 'shoppingcart.incrementQuantityCartItem', 'uses' => 'frontend\ShoppingCartController@incrementQuantityCartItem']);
    Route::get('shoppingcart/checkout/{user_id}/{total}', ['as' => 'shoppingcart.checkout', 'uses' => 'frontend\ShoppingCartController@checkout']);
    Route::post('shoppingcart/checkoutAll', ['as' => 'shoppingcart.checkoutAll', 'uses' => 'frontend\ShoppingCartController@checkoutAll']);

    Route::get('/information/removeproduct/ajax-state',function()
    {
        $stateid = Input::get('stateid');
        /*$productStandards = \App\ProductStandard::where('product_request_id',$stateid)->get();
        foreach($productStandards as $productStandard){
            $productStandard->delete();
        }*/
        $Iwantto = ProductRequest::find($stateid);
        $Iwantto->standards()->detach();
        $Iwantto->delete();
        return [];

    });
    Route::get('userproduct/all','frontend\ProductController@all');
    Route::resource('userproduct','frontend\ProductController');
    Route::get('userproduct-filters','frontend\ProductController@index');
    Route::get('promotion/index','frontend\PromotionsController@index');
    Route::resource('promotion','frontend\PromotionsController');
    Route::get('order','frontend\OrderController@index');
    Route::get('shoporder','frontend\OrderController@shoporder');
    Route::get('orderdetail/{order_id}','frontend\OrderController@orderdetail');
    Route::get('quotation/index','frontend\QuotationController@index');
    Route::get('quotationRequest/{product_request_id}/{quantity}','frontend\QuotationController@store');
    Route::get('quote/index','frontend\QuoteController@index');
//    Route::get('quotation/reply/{product_request_id}','frontend\QuotationController@reply');
    Route::resource('quotation','frontend\QuotationController');
    Route::resource('quote','frontend\QuoteController');
    Route::get('orderdetail/html-payment-channel/{id}','frontend\OrderController@getHtmlConfirmSale');
    Route::post('orderdetail/store-status-history','frontend\OrderController@storeStatusHistory');

    //Route::get('userproduct/index','frontend\ProductController@index');
    Route::post('recommend-promotion/{id}','frontend\PromotionsController@recommendPromotion');

    //Reports
    Route::get('reports/buy','frontend\ReportsController@index');
    Route::post('reports/buy','frontend\ReportsController@actionFilter');
    Route::post('reports/buy/export','frontend\ReportsController@actionExportExcel');
    Route::get('reports/buy/download','frontend\ReportsController@actionDownload');
    Route::get('reports/sale','frontend\ReportsController@SaleItemIndex');
    Route::post('reports/sale','frontend\ReportsController@SaleItemFilter');
    Route::get('reports/list-sale','frontend\ReportsController@listSale');
    Route::get('reports/getproductbycate/{id}','frontend\ReportsController@getProductByCate');

    Route::post('quotation/checkout', 'frontend\QuotationController@checkout');



});

Route::group(['prefix' => 'admin','middleware' => ['admin']], function () {
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
    Route::resource('badword','backend\BadWordController');
    Route::post('censor','backend\BadWordController@censor');
    //Reports
    Route::get('reports/buy','backend\ReportsController@index');
//    Route::post('reports/buy','backend\ReportsController@actionFilter');
    Route::post('reports/buy/export','backend\ReportsController@actionExportExcel');
    Route::get('reports/buy/download','backend\ReportsController@actionDownload');
    Route::get('reports/sale','backend\ReportsController@SaleItemIndex');
    Route::post('reports/sale/export','backend\ReportsController@saleExportExcel');
    Route::get('reports/salebyshop','backend\ReportsController@SaleItemByShop');
    Route::post('reports/salebyshop/export','backend\ReportsController@SaleItemByShopExportExcel');
//    Route::post('reports/sale','backend\ReportsController@SaleItemFilter');
//    Route::post('reports/salebyshop','backend\ReportsController@SaleItemByShopFilter');
    Route::get('reports/orderdetail/{order_id}','backend\ReportsController@orderdetail');
    Route::get('reports/getproductbycate/{id}','backend\ReportsController@getProductByCate');

    //Reports shops
    Route::get('reports/shop','backend\ReportShopsController@reportShop');
    Route::post('reports/shop','backend\ReportShopsController@shopFilter');
    Route::post('reports/shop/export','backend\ReportShopsController@shopExportExcel');
    Route::get('reports/shop/download','backend\ReportShopsController@actionDownload');
    //Reports Products
    Route::get('reports/product','backend\ReportProductsController@index');
    Route::post('reports/product','backend\ReportProductsController@filter');
    Route::post('reports/product/export','backend\ReportProductsController@exportExcel');
    //Report OrderStatusHistory
    Route::get('reports/orders','backend\ReportOrderStatusHistoryController@orderList');
//    Route::post('reports/orders','backend\ReportOrderStatusHistoryController@filter');
    Route::get('reports/orders/{id}/show','backend\ReportOrderStatusHistoryController@show');
    Route::post('reports/orders/export','backend\ReportOrderStatusHistoryController@exportExcel');
    //Report OrderHistoryByemp
    Route::get('reports/order-history-sale-buy','backend\ReportOrderHistoryController@index');
//    Route::post('reports/order-history-sale-buy','backend\ReportOrderHistoryController@filter');
    Route::post('reports/order-history-sale-buy/export','backend\ReportOrderHistoryController@exportExcel');
    //Reports Matching
    Route::get('reports/matching','backend\ReportMatchingController@index');
//    Route::post('reports/matching','backend\ReportMatchingController@matchingFilter');
    Route::post('reports/matching/export','backend\ReportMatchingController@exportExcel');
    Route::get('reports/matching/download','backend\ReportMatchingController@actionDownload');

});

Route::get('{shop}/promotion/{id}', 'frontend\ShopIndexController@promotion');


Route::get('/{shop}', 'frontend\ShopIndexController@index');
Route::post('/{shop}/{id}/{key}', 'frontend\ShopIndexController@storeComment');
Route::post('/{shop}/{id}', 'frontend\ShopIndexController@updateCommentStatus');

//Route::get('/migrate/usermarket/{key}', 'MigrateController@user_market');
//Route::get('/migrate/productmarket/{key}', 'MigrateController@product_market');
Route::get('/migrate/productprovince/', 'MigrateController@product_province');
Route::get('/migrate/badword/', 'MigrateController@badword');
Route::get('/fix/product/', 'FixController@removeDubProduct');
//Route::get('/{shop}', ['middleware' => ['shop']], 'frontend\ShopIndexController@index');