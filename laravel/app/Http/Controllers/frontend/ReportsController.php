<?php

namespace App\Http\Controllers\frontend;
use Illuminate\Routing\Controller;

use DB,Response;
use App\Order;
use App\OrderItem;
use App\OrderStatusHistory;
use App\OrderPayment;
use Illuminate\Http\Request;
use App\Helpers\DateFuncs;

class ReportsController extends Controller
{
    public function index()
    {
        $user = auth()->guard('user')->user();
        $orderLists = Order::join('order_status', 'order_status.id', '=', 'orders.order_status')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->select('orders.*', 'order_status.status_name','users.users_firstname_th','users.users_lastname_th')
            ->where('orders.buyer_id', $user->id)
            ->orderBy('orders.id', 'DESC')
            ->paginate(config('app.paginate'));

        return view('frontend.reports.orderlist', compact('orderLists'));
    }

    public function actionFilter(Request $request)
    {
        $user = auth()->guard('user')->user();
        echo "xxxxxxxxxxxxxxxxxxxxxxx";
        exit();
        $orderLists = '';
        if(!empty($request->input('filter')) and $request->isMethod('post')){
            $start_date='';
            $end_date='';
            if(!empty($request->input('end_date'))){
                $start_date = DateFuncs::convertYear($request->input('start_date'));
            }
            if(!empty($request->input('end_date'))){
                $end_date = DateFuncs::convertYear($request->input('end_date'));
            }
            return $request->all();
            $filter = $request->input('filter');
            $orderList = Order::join('order_status', 'order_status.id', '=', 'orders.order_status');
            $orderList->join('users', 'users.id', '=', 'orders.user_id');

            $orderList->select(DB::raw('orders.*, order_status.status_name,users.users_firstname_th,users.users_lastname_th'));
            $orderList->where('orders.buyer_id', $user->id);
            $orderList->where(function($query) use ($filter) {
                $query->where('orders.id', 'like', '%' . $filter . '%');
                $query->orWhere('users.users_firstname_th', 'like', '%' . $filter . '%');
                $query->orWhere('order_status.status_name', 'like', '%' . $filter . '%');
            });
            $orderList->orderBy('orders.id', 'DESC');
            $orderList->paginate(config('app.paginate'));
            $orderLists = $orderList->paginate(config('app.paginate'));
        }
        return view('frontend.reports.orderlist', compact('orderLists'));
    }
}
