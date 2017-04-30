<?php

namespace App\Http\Controllers\frontend;

use App\Order;
use App\OrderItem;
use App\ProductRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->guard('user')->user();
        $orderList = \App\Order::with('user')->where('buyer_id', $user->id)
            ->orderBy('id', 'DESC')
            ->paginate(config('app.paginate'));

        $data = array('user_id' => $user->id,
            'i' => ($request->input('page', 1) - 1) * config('app.paginate'));

        return view('frontend.orderindex', compact('orderList'))
            ->with($data);
    }

    public function shoporder(Request $request)
    {
        $user = auth()->guard('user')->user();
        $orderList = \App\Order::with('buyer')->where('user_id', $user->id)
            ->orderBy('id', 'DESC')
            ->paginate(config('app.paginate'));

        $data = array('user_id' => $user->id,
            'i' => ($request->input('page', 1) - 1) * config('app.paginate'));

        return view('frontend.shoporder', compact('orderList'))
            ->with($data);
    }

    public function orderdetail($order_id){
//        $user = auth()->guard('user')->user();
        $order = Order::with('user')->where('id', $order_id)->first();
        $order->orderItems = ProductRequest::with(['orderItem','product'])->where('id',255)->get();
        /*$order->orderItems = ProductRequest::with(['orderItem','product'])->whereHas('OrderItem', function($query) use ($order_id){
            $query->whereOrderId($order_id);
        })->get();*/
        echo $order;
        exit();
        return view('frontend.orderdetail', compact('order'));
    }

    public function shoporderdetail($order_id){
//        $user = auth()->guard('user')->user();
        $order = Order::with('user')->where('id', $order_id)->first();
        $order->orderItems = ProductRequest::with(['orderItem','product'])->where('id',255)->get();
        /*$order->orderItems = ProductRequest::with(['orderItem','product'])->whereHas('OrderItem', function($query) use ($order_id){
            $query->whereOrderId($order_id);
        })->get();*/
        echo $order;
        exit();
        return view('frontend.shoporderdetail', compact('order'));
    }
}