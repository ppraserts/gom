<?php

namespace App\Http\Controllers;

use App\Market;
use App\Model\frontend\User;
use App\ProductRequest;
use App\ProductRequestMarket;
use App\UserMarket;

class MigrateController extends Controller
{
    public function user_market($key)
    {
        if ($key == 'artisan') {
            $users = User::where('iwanttosale', 'sale')->get();
            $markets = Market::all();
            foreach ($users as $user) {
                foreach ($markets as $market) {
                    if (UserMarket::create(['user_id' => $user->id, 'market_id' => $market->id])) {
                        echo 'product_request_id = ' . $user->id . " | market_id = " . $market->id . "<br>";
                    }
                }
            }
        }
    }

    public function product_market($key)
    {
        if ($key == 'artisan') {

            $productRequests = ProductRequest::where('iwantto', 'sale')->get();
            $markets = Market::all();
            foreach ($productRequests as $productRequest) {
                foreach ($markets as $market) {
                    if (ProductRequestMarket::create(['product_request_id' => $productRequest->id, 'market_id' => $market->id])) {
                        echo 'product_request_id = ' . $productRequest->id . " | market_id = " . $market->id . "<br>";
                    }
                }
                $productRequest->selling_type = 'all';
                $productRequest->save();
            }

        }
    }
}
