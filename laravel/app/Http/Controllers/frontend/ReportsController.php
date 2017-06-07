<?php

namespace App\Http\Controllers\frontend;
use Illuminate\Routing\Controller;

use DB,Validator, Response;
use App\Order;
use Excel;
use Storage;
use App\OrderPayment;
use App\Product;
use Illuminate\Http\Request;
use App\Helpers\DateFuncs;


class ReportsController extends Controller
{

    public function index()
    {
        $user = auth()->guard('user')->user();
        $products = Product::all();
        $orderLists = Order::join('order_status', 'order_status.id', '=', 'orders.order_status')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->select('orders.*', 'order_status.status_name','users.users_firstname_th','users.users_lastname_th')
            ->where('orders.buyer_id', $user->id)
            ->orderBy('orders.id', 'DESC')
            ->paginate(config('app.paginate'));
        return view('frontend.reports.orderlist', compact('orderLists','products'));
    }

    public function actionFilter(Request $request)
    {
        $user = auth()->guard('user')->user();
        $v = Validator::make($request->all(), [
            'start_date' => 'required',
            'end_date' => 'required',
            'product_type_name' => 'required'
        ]);
        if ($v->fails()){ return redirect()->back()->withErrors($v->errors()); }

        $orderLists = '';
        if($request->isMethod('post')){
           $start_date = DateFuncs::convertYear($request->input('start_date'));
           $end_date = DateFuncs::convertYear($request->input('end_date'));
            $productTypeNameArr = $request->input('product_type_name');
            $orderList = Order::join('order_status', 'order_status.id', '=', 'orders.order_status');
            $orderList->join('users', 'users.id', '=', 'orders.user_id');
            $orderList->join('order_items', 'order_items.order_id', '=', 'orders.id');
            $orderList->join('product_requests', 'product_requests.id', '=', 'order_items.product_request_id');
            $orderList->join('products', 'products.id', '=', 'product_requests.products_id');
            $orderList->select(DB::raw('orders.*, order_status.status_name,users.users_firstname_th,users.users_lastname_th'));
            $orderList->where('orders.buyer_id', $user->id);
            $orderList->whereIn('products.id', $productTypeNameArr);
            $orderList->where('orders.order_date','>=', $start_date);
            $orderList->where('orders.order_date','<=', $end_date);
            $orderList->groupBy('orders.id');
            $orderList->orderBy('orders.id', 'DESC');
            $orderList->paginate(config('app.paginate'));
            $orderLists = $orderList->paginate(config('app.paginate'));

            $products = Product::all();
            return view('frontend.reports.orderlist', compact('orderLists','products','productTypeNameArr'));
        }
    }

    public function actionExportExcel(Request $request)
    {
        if($request->ajax()){
//            $user = auth()->guard('user')->user();
//            $start_date = DateFuncs::convertYear($request->input('start_date'));
//            $end_date = DateFuncs::convertYear($request->input('end_date'));
//            $productTypeNameArr = $request->input('product_type_name');
//            $orderList = Order::join('order_status', 'order_status.id', '=', 'orders.order_status');
//            $orderList->join('users', 'users.id', '=', 'orders.user_id');
//            $orderList->join('order_items', 'order_items.order_id', '=', 'orders.id');
//            $orderList->join('product_requests', 'product_requests.id', '=', 'order_items.product_request_id');
//            $orderList->join('products', 'products.id', '=', 'product_requests.products_id');
//            $orderList->select(DB::raw('orders.*, order_status.status_name,users.users_firstname_th,users.users_lastname_th'));
//            $orderList->where('orders.buyer_id', $user->id);
//            $orderList->whereIn('products.id', $productTypeNameArr);
//            $orderList->where('orders.order_date','>=', $start_date);
//            $orderList->where('orders.order_date','<=', $end_date);
//            $orderList->groupBy('orders.id');
//            $orderList->orderBy('orders.id', 'DESC');
//            $orderList->paginate(config('app.paginate'));
//            $orderLists = $orderList->paginate(config('app.paginate'));
            $data = array(
                array('data1', 'data2'),
                array('data3', 'data4')
            );
            $info = Excel::create('Laravel_Excel', function($excel) use($data) {
                $excel->sheet('Sheetname', function($sheet) use($data) {
                    $sheet->fromArray($data);
                });
            })->store('xls', false, true);
            return response()->json(array('file'=>$info['file']));
        }
    }

    public function actionDownload(Request $request)
    {
        $path  = storage_path().'/exports/'.$request->input('file');
        return response()->download($path);
    }

}
