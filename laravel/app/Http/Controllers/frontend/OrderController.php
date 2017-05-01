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
        /*$orderList = \App\Order::with(['user','orderStatusName'])->where('buyer_id', $user->id)->get();
        echo $orderList;
        exit();*/
        $orderList = \App\Order::with(['user','orderStatusName'])->where('buyer_id', $user->id)
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
        $orderList = \App\Order::with(['buyer','orderStatusName'])->where('user_id', $user->id)
            ->orderBy('id', 'DESC')
            ->paginate(config('app.paginate'));

        $data = array('user_id' => $user->id,
            'i' => ($request->input('page', 1) - 1) * config('app.paginate'));

        return view('frontend.shoporder', compact('orderList'))
            ->with($data);
    }

    public function orderdetail($order_id){
//        $user = auth()->guard('user')->user();
        $order = Order::with(['user','orderStatusName'])->where('id', $order_id)->first();
//        $order->orderItems = OrderItem::with(['product','productRequest'])->where('order_id',$order_id)->get();
        $OrderItem = new OrderItem();
        $order->orderItems = $OrderItem->orderItemDetail($order_id);
//        echo $order;
//        exit();
        return view('frontend.orderdetail', compact('order'));
    }
}