<?php
namespace App\Http\Controllers\backend;

use DB;
use App\Order;
use App\OrderPayment;
use Hash;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderStatusHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function orderList(Request $request){
        if(!empty($request->input('filter'))){
            $filter = $request->input('filter');
            $results = Order::join('order_status', 'order_status.id', '=', 'orders.order_status')
                ->join('users', 'users.id', '=', 'orders.user_id')
                ->select('orders.*', 'order_status.status_name','users.users_firstname_th','users.users_lastname_th')
                ->where(function($query) use ($filter) {
                    $query->where('orders.id', 'like', '%' . $filter . '%');
                    $query->orWhere('users.users_firstname_th', 'like', '%' . $filter . '%');
                    $query->orWhere('order_status.status_name', 'like', '%' . $filter . '%');
                })
                ->orderBy('orders.id', 'DESC')
                ->paginate(config('app.paginate'));
        }else {
            $results = Order::join('order_status', 'order_status.id', '=', 'orders.order_status')
                ->join('users', 'users.id', '=', 'orders.user_id')
                ->select('orders.*', 'order_status.status_name', 'users.users_firstname_th', 'users.users_lastname_th')
                ->orderBy('orders.id', 'DESC')
                ->paginate(config('app.paginate'));
        }
        return view('backend.reports.order_status_history', compact('results'));
    }

}