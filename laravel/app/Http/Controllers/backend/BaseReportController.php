<?php
namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;
use App\ProductCategory;
use App\Product;
class BaseReportController extends Controller {

    public static function productsByCategory($productCateId)
    {
        return $products = Product::select(DB::raw('products.id,products.product_name_th'))
            ->where('products.productcategory_id', $productCateId)->get();
    }
    public  static function productCategorys(){
        return ProductCategory::all();
    }



}