<?php
/**
 * Created by PhpStorm.
 * User: BERM-PC
 * Date: 11/3/2560
 * Time: 12:42
 */

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Support\Facades\Session;

class ShoppingCartController extends Controller
{

    public function __construct()
    {
        $this->middleware('user');
    }

    public function index()
    {
//        $order = new Order();
//        $order->id = 1;
//        $order->order_status = 2;
//        $order->total_amount = 1000;
//        session(['order' => $order]);

//        $orders = array();
//
//        $order1 = new Order();
//        $order1->id = 1;
//        $order1->order_status = 2;
//        $order1->total_amount = 1000;
//
//        $order2 = new Order();
//        $order2->id = 2;
//        $order2->order_status = 3;
//        $order2->total_amount = 555;


//        array_push($orders, $order1);
//        array_push($orders, $order2);
//
//        session(['orders' => $orders]);


//         $orders = session('orders');

         return view('frontend.shopping.shopping_cart' , compact('orders'));
    }


}
