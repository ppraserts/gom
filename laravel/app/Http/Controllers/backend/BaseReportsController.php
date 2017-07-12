<?php
namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;
use App\ProductCategory;
use App\OrderStatus;
use App\Product;
use DB;
class BaseReportsController extends Controller {

    public static function productsByCategory($productCateId)
    {
        return $products = Product::select(DB::raw('products.id,products.product_name_th'))
            ->where('products.productcategory_id', $productCateId)->get();
    }
    public  static function productCategorys(){
        return ProductCategory::orderBy('sequence','ASC')->get();
    }
    public  static function productCategory($id){
        return ProductCategory::where('productcategorys.id', $id)->first();
    }

    public  static function orderStatus($id){
        return OrderStatus::where('order_status.id', $id)->first();
    }

    public  static function dateToDayAndLastMonth(){
        $ymd_today  = date('Y-m-d');
        $ymd_last_month = date('Y-m-d', strtotime('last month'));
        return $date = array('ymd_today'=>$ymd_today,'ymd_last_month'=>$ymd_last_month);
    }



}