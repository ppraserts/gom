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
            $user = auth()->guard('user')->user();
            //return $request->input('product_type_name');

            $orderList = Order::join('order_status', 'order_status.id', '=', 'orders.order_status');
            $orderList->join('users', 'users.id', '=', 'orders.user_id');
            $orderList->join('order_items', 'order_items.order_id', '=', 'orders.id');
            $orderList->join('product_requests', 'product_requests.id', '=', 'order_items.product_request_id');
            $orderList->join('products', 'products.id', '=', 'product_requests.products_id');
            $orderList->select(DB::raw('orders.*, order_status.status_name,users.users_firstname_th,users.users_lastname_th'));
            $orderList->where('orders.buyer_id', $user->id);
            if(!empty($request->input('start_date'))){
                $start_date = DateFuncs::convertYear($request->input('start_date'));
                $orderList->where('orders.order_date','>=', $start_date);
            }
            if(!empty($request->input('end_date'))) {
                $end_date = DateFuncs::convertYear($request->input('end_date'));
                $orderList->where('orders.order_date','<=', $end_date);
            }
            if(!empty($request->input('product_type_name'))) {
                $productTypeNameArr = $request->input('product_type_name');
                $orderList->whereIn('products.id', $productTypeNameArr);
            }
            $orderList->groupBy('orders.id');
            $orderList->orderBy('orders.id', 'DESC');
            $orderList->paginate(config('app.paginate'));
            $orderLists = $orderList->paginate(config('app.paginate'));

            $arr[] = array(
                trans('messages.order_id'),
                trans('messages.i_sale'),
                trans('messages.order_date'),
                trans('messages.order_total'),
                trans('messages.order_status')
            );
            foreach ($orderLists as $v){
                $arr[] = array(
                    $v->id,
                    $v->users_firstname_th. " ". $v->users_lastname_th,
                    $v->order_date,
                    $v->total_amount . trans('messages.baht'),
                    $v->status_name
                );
            }
            $data = $arr;
            $info = Excel::create('orders-list-buy-excel', function($excel) use($data) {

                $excel->sheet('Sheetname', function($sheet) use($data) {
                    $sheet->cell('A1:E1', function($cell) {
                        $cell->setFontWeight('bold');
                    });
                    $sheet->rows($data);
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

    //Report List Sale Item
    public function SaleItemIndex()
    {
        $user = auth()->guard('user')->user();
        $product = Order::join('order_status', 'order_status.id', '=', 'orders.order_status');
        $product->join('users', 'users.id', '=', 'orders.user_id');
        $product->join('order_items', 'order_items.order_id', '=', 'orders.id');
        $product->join('product_requests', 'product_requests.id', '=', 'order_items.product_request_id');
        $product->join('products', 'products.id', '=', 'product_requests.products_id');
        $product->select(DB::raw('products.*'));
        $product->where('orders.user_id', $user->id);
        $product->groupBy('products.id');
        $product->orderBy('products.id', 'DESC');
        $products = $product->get();
        //
        $orderList = Order::join('order_status', 'order_status.id', '=', 'orders.order_status');
        $orderList->join('users', 'users.id', '=', 'orders.user_id');
        $orderList->join('order_items', 'order_items.order_id', '=', 'orders.id');
        $orderList->join('product_requests', 'product_requests.id', '=', 'order_items.product_request_id');
        $orderList->join('products', 'products.id', '=', 'product_requests.products_id');
        $orderList->select(DB::raw('SUM(orders.total_amount) as total_amounts, products.product_name_th
        , products.product_name_en'));
        $orderList->where('orders.user_id', $user->id);
        $orderList->where('orders.order_status', '!=', 5);
        $orderList->groupBy('products.id');
        $orderList->orderBy('orders.id', 'DESC');
//        $orderSaleItem = $orderList->paginate(config('app.paginate'));
        //return $orderSaleItem;
        $orderSaleItem = $orderList->get();
        $sumAll=0;
        foreach ($orderSaleItem as $value){
           $sumAll = $sumAll + $value->total_amounts;
        }
//mock data
//        $arr = array();
//        for ($i=0; $i <= 100; $i++){
//            $object = (object)[];
//            $object->total_amounts = $i;
//            $object->product_name_th = 'xx'.$i;
//            $object->product_name_en='ccc'.$i;
//            array_push($arr,$object);
//        }
//        $orderSaleItem = $arr;
        return view('frontend.reports.sale_item_list', compact('orderSaleItem','products','sumAll'));
    }

    public function SaleItemFilter(Request $request)
    {
        $user = auth()->guard('user')->user();
        $v = Validator::make($request->all(), [
            'start_date' => 'required',
            'end_date' => 'required',
            'product_type_name' => 'required'
        ]);
        if ($v->fails()){ return redirect()->back()->withErrors($v->errors()); }

        $orderSaleItem = '';
        if($request->isMethod('post')){
            $start_date = DateFuncs::convertYear($request->input('start_date'));
            $end_date = DateFuncs::convertYear($request->input('end_date'));
            $productTypeNameArr = $request->input('product_type_name');
            $orderList = Order::join('order_status', 'order_status.id', '=', 'orders.order_status');
            $orderList->join('users', 'users.id', '=', 'orders.user_id');
            $orderList->join('order_items', 'order_items.order_id', '=', 'orders.id');
            $orderList->join('product_requests', 'product_requests.id', '=', 'order_items.product_request_id');
            $orderList->join('products', 'products.id', '=', 'product_requests.products_id');
            $orderList->select(DB::raw('SUM(orders.total_amount) as total_amounts, products.product_name_th
        , products.product_name_en'));
            $orderList->where('orders.user_id', $user->id);
            $orderList->whereIn('products.id', $productTypeNameArr);
            $orderList->where('orders.order_date','>=', $start_date);
            $orderList->where('orders.order_date','<=', $end_date);
            $orderList->where('orders.order_status', '!=', 5);
            $orderList->groupBy('products.id');
            $orderList->orderBy('orders.id', 'DESC');
            $orderList->paginate(config('app.paginate'));
//            $orderSaleItem = $orderList->paginate(config('app.paginate'));
            $orderSaleItem = $orderList->get();
            //products
            $product = Order::join('order_status', 'order_status.id', '=', 'orders.order_status');
            $product->join('users', 'users.id', '=', 'orders.user_id');
            $product->join('order_items', 'order_items.order_id', '=', 'orders.id');
            $product->join('product_requests', 'product_requests.id', '=', 'order_items.product_request_id');
            $product->join('products', 'products.id', '=', 'product_requests.products_id');
            $product->select(DB::raw('products.*'));
            $product->where('orders.user_id', $user->id);
            $product->groupBy('products.id');
            $product->orderBy('products.id', 'DESC');
            $products = $product->get();
            //
            $sumAll=0;
            foreach ($orderSaleItem as $value){
                $sumAll = $sumAll + $value->total_amounts;
            }
            //return $orderSaleItem;
            return view('frontend.reports.sale_item_list', compact('orderSaleItem','products','productTypeNameArr','sumAll'));
        }
    }

}
