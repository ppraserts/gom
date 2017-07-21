<?php

namespace App\Http\Controllers;


use App\Product;
use App\ProductRequest;
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
        foreach ($products as $product){

            $myProducts = Product::where('product_name_th',$product->product_name_th)
                ->get();

            if (count($myProducts)>1){
                $firstID = 0;
                for ($i =0;$i<count($myProducts);$i++){
//                    echo "-------$line---- ".$myProducts[$i]->id." ----$i<br>";
//                    $line++;
                    if ($i==0 || $firstID ==0){
                        $firstID = $myProducts[$i]->id;
                    }else{
                        $wanttobuys = ProductRequest::where('products_id',$myProducts[$i]->id)
                            ->get();
                        if (count($wanttobuys)<1){
//                            echo "-------$line---- ".$myProducts[$i]->id." ----$i Empty !!!!!!!!<br>";
                        }
                        foreach ($wanttobuys as $wanttobuy){
                            echo $wanttobuy->product_title.' change products_id : '.$wanttobuy->products_id.' to '.$firstID.'<br>';
                            $wanttobuy->products_id = $firstID;
                            $wanttobuy->save();
                        }
                        $myProducts[$i]->delete();
                        echo 'delete duplicate products : '.$myProducts[$i]->id." : ".$myProducts[$i]->product_name_th.' <br>';
                    }
                }
            }else{
                echo "no diff<br>";
            }
        }

        echo "################ COMPLETE ################";
    }

}
