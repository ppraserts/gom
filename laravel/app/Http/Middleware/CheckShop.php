<?php
/**
 * Created by PhpStorm.
 * User: BERM-PC
 * Date: 6/4/2560
 * Time: 19:52
 */

namespace App\Http\Middleware;
use Closure;


class CheckShop
{
    public function handle($request, Closure $next)
    {
        if(!empty(auth()->guard('user')->id()))
        {
            $session_shop_name = session('shop')['shop_name'] ;
            if(!trim( strtolower($session_shop_name) == trim(strtolower($request->segment(1))))  ){
                return abort(404);
            }
           return $next($request);
        }
        else
        {
            return abort(404);
        }
    }
}