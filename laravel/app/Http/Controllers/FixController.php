<?php

namespace App\Http\Controllers;


use App\Amphur;
use App\District;
use App\Product;
use App\ProductRequest;
use App\Province;
use Illuminate\Support\Facades\DB;

class FixController extends Controller
{
    public function removeDubProduct()
    {
        echo "################ START ################<br>";
        $products = DB::select(
            DB::raw("SELECT COUNT(`product_name_th`) as dup ,products.* 
                FROM `products` 
                GROUP by `product_name_th`
                having count(product_name_th) > 1"));

        $line = 1;
        foreach ($products as $product) {

            $myProducts = Product::where('product_name_th', $product->product_name_th)
                ->get();

            if (count($myProducts) > 1) {
                $firstID = 0;
                for ($i = 0; $i < count($myProducts); $i++) {
//                    echo "-------$line---- ".$myProducts[$i]->id." ----$i<br>";
//                    $line++;
                    if ($i == 0 || $firstID == 0) {
                        $firstID = $myProducts[$i]->id;
                    } else {
                        $wanttobuys = ProductRequest::where('products_id', $myProducts[$i]->id)
                            ->get();
                        if (count($wanttobuys) < 1) {
//                            echo "-------$line---- ".$myProducts[$i]->id." ----$i Empty !!!!!!!!<br>";
                        }
                        foreach ($wanttobuys as $wanttobuy) {
                            echo $wanttobuy->product_title . ' change products_id : ' . $wanttobuy->products_id . ' to ' . $firstID . '<br>';
                            $wanttobuy->products_id = $firstID;
                            $wanttobuy->save();
                        }
                        $myProducts[$i]->delete();
                        echo 'delete duplicate products : ' . $myProducts[$i]->id . " : " . $myProducts[$i]->product_name_th . ' <br>';
                    }
                }
            } else {
                echo "no diff<br>";
            }
        }

        echo "################ COMPLETE ################";
    }

    public function fixMatchingProvince()
    {
        $productSales = ProductRequest::where('iwantto', 'sale')->get();

        foreach ($productSales as $productRequest) {
            $sourceProvince = Province::where('PROVINCE_NAME', $productRequest->province)->first();
            if ($sourceProvince != null) {
                $productRequest->province_source = $sourceProvince->PROVINCE_ID;
            } else {
                $productRequest->province_source = 0;
            }
            if ($productRequest->province_selling == '') {
                $productRequest->province_selling = 0;
            }

            $sellingProvince = Province::where('PROVINCE_ID', $productRequest->province_selling)->first();
            if ($sellingProvince != null) {

                if ($productRequest->province_selling === 0) {
                    echo 'change '.$productRequest->province.' to ';
                    $productRequest->province = trans('messages.allprovince');
                    echo $productRequest->province . '<br>';
                }else {
                    echo 'change '.$productRequest->province.' to ';
                    $productRequest->province = $sellingProvince->PROVINCE_NAME;
                    echo $productRequest->province . '<br>';
                }
            }else{
                echo 'change '.$productRequest->province.' to ';
                $productRequest->province = trans('messages.allprovince');
                echo $productRequest->province . '<br>';
            }
            echo '----------------------------<br>';
            $productRequest->save();
        }

        $productBuys = ProductRequest::where('iwantto', 'buy')->get();
        foreach ($productBuys as $productRequest){
            $sellingProvince = Province::where('PROVINCE_NAME', $productRequest->province)->first();
            if ($sellingProvince!=null){
                $productRequest->province_selling = $sellingProvince->PROVINCE_ID;
            }else{
                $sellingProvinceByID = Province::where('PROVINCE_ID', $productRequest->sellingProvince)->first();
                if ($sellingProvinceByID!=null){
                    $productRequest->province = $sellingProvinceByID->PROVINCE_NAME;
                }else{
                    $productRequest->province_selling = 0;
                    $productRequest->province = trans('messages.allprovince');
                }
            }
            $productRequest->save();
        }
    }

    public function fixStarAmphurDistrict(){
        District::where('DISTRICT_NAME','like','%*%')->delete();
        Amphur::where('AMPHUR_NAME','like','%*%')->delete();
        echo '########### SUCCESS ############';
    }

}
