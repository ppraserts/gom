<?php

namespace App\Http\Controllers\frontend;
use DB;
use App\Order;
use App\OrderItem;
use App\OrderStatusHistory;
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
        $orderList = '';
        if(!empty($request->input('filter'))){
            $filter = $request->input('filter');
            $orderList = \App\Order::join('order_status', 'order_status.id', '=', 'orders.order_status')
                ->join('users', 'users.id', '=', 'orders.user_id')
                ->select('orders.*', 'order_status.status_name','users.users_firstname_th','users.users_lastname_th')
                ->where('orders.buyer_id', $user->id)
                ->where(function($query) use ($filter) {
                    $query->where('orders.id', 'like', '%' . $filter . '%');
                    $query->orWhere('users.users_firstname_th', 'like', '%' . $filter . '%');
                    $query->orWhere('order_status.status_name', 'like', '%' . $filter . '%');
                })
                ->orderBy('orders.id', 'DESC')
                ->paginate(config('app.paginate'));
        }else{
            $orderList = \App\Order::join('order_status', 'order_status.id', '=', 'orders.order_status')
                ->join('users', 'users.id', '=', 'orders.user_id')
                ->select('orders.*', 'order_status.status_name','users.users_firstname_th','users.users_lastname_th')
                ->where('orders.buyer_id', $user->id)
                ->orderBy('orders.id', 'DESC')
                ->paginate(config('app.paginate'));
        }


        $data = array('user_id' => $user->id,
            'i' => ($request->input('page', 1) - 1) * config('app.paginate'));
        return view('frontend.orderindex', compact('orderList'))
            ->with($data);
    }

    public function shoporder(Request $request)
    {
        $user = auth()->guard('user')->user();
        $orderList = \App\Order::join('order_status', 'order_status.id', '=', 'orders.order_status')
            ->join('users', 'users.id', '=', 'orders.buyer_id')
            ->select('orders.*', 'order_status.status_name','users.users_firstname_th','users.users_lastname_th')
            ->where('orders.user_id', $user->id)
            ->orderBy('orders.id', 'DESC')
            ->paginate(config('app.paginate'));

        $data = array('user_id' => $user->id,
            'i' => ($request->input('page', 1) - 1) * config('app.paginate'));

        return view('frontend.shoporder', compact('orderList'))
            ->with($data);
    }

    public function orderdetail($order_id){
//        $user = auth()->guard('user')->user();
        $order = Order::join('order_status', 'order_status.id', '=', 'orders.order_status')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->select('orders.*', 'order_status.status_name','users.users_firstname_th','users.users_lastname_th')
            ->where('orders.id', $order_id)->first();
//        $order->orderItems = OrderItem::with(['product','productRequest'])->where('order_id',$order_id)->get();
        $orderItem = new OrderItem();
        $order->orderItems = $orderItem->orderItemDetail($order_id);
        $order->statusHistory = OrderStatusHistory::join('order_status', 'order_status.id', '=', 'order_status_history.status_id')
            ->select('order_status_history.created_at','order_status.status_name')
            ->where('order_id',$order_id)->get();
        /*echo $order;
        exit();*/
        return view('frontend.orderdetail', compact('order'));
    }
}