<?php
/**
 * Created by PhpStorm.
 * User: BERM-PC
 * Date: 6/4/2560
 * Time: 19:52
 */

namespace App\Http\Middleware;

use App\Shop;
use Closure;


class CheckShop
{
    public function handle($request, Closure $next)
    {
        $shop = Shop::where('shop_name',$request->segment(1))->get();
//        echo count($shop);
        if (count($shop)<1) {
            return abort(404);
        }
        return $next($request);
    }
}