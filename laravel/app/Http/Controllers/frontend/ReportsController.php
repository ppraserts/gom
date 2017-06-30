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

            $productTypeNameArr = $request->input('product_type_name');
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $buyer_id = $user->id;
            $orderLists = $this->getOrders($buyer_id,$start_date,$end_date,$productTypeNameArr);

            $productStr = trans('messages.show_all');
            if(!empty($productTypeNameArr)){
                $res = $this->getProductCate($productTypeNameArr);
                foreach ($res as $re){
                    $productStrs[] = $re->product_name_th;
                }
                $productStr = implode(",",$productStrs);
            }
            $str_start_and_end_date = trans('messages.text_start_date').' : - '.trans('messages.text_end_date').' : -';
            if(!empty($start_date) and !empty($end_date)){
                $str_start_and_end_date = trans('messages.text_start_date').' : '.$start_date.' '.trans('messages.text_end_date').' : '.$end_date;
            }


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
            $info = Excel::create(' dgtfarm-orders-buy-excel', function($excel) use($data,$productStr,$str_start_and_end_date) {
                $excel->sheet('Sheetname', function($sheet) use($data,$productStr,$str_start_and_end_date) {
                    $sheet->mergeCells('A1:E1');
                    $sheet->mergeCells('A2:E3');
                    $sheet->mergeCells('A4:E5');
                    $sheet->mergeCells('A6:E7');
                    $sheet->setSize(array(
                        'A1' => array(
                            'height'    => 50
                        )
                    ));
                    $sheet->setAutoSize(array('A'));
                    $sheet->cells('A1', function($cells) {
                        $cells->setValue(trans('messages.menu_order_list'));
                        $cells->setValignment('center');
                        $cells->setAlignment('center');
                        $cells->setFont(array(
                            'size'       => '16',
                            'bold'       =>  true
                        ));
                    });

                    $sheet->cells('A2', function($cells) use($productStr) {
                        $cells->setValue(trans('messages.menu_add_product').': '.$productStr);
                        $cells->setFont(array(
                            'bold'       =>  true
                        ));
                        $cells->setValignment('center');
                    });
                    $sheet->cells('A4', function($cells) use($str_start_and_end_date) {
                        $cells->setValue($str_start_and_end_date);
                        $cells->setFont(array(
                            'bold'       =>  true
                        ));
                        $cells->setValignment('center');
                    });
                    $sheet->cells('A6', function($cells) {
                        $cells->setValue(trans('messages.datetime_export').': '.DateFuncs::convertToThaiDate(date('Y-m-d')).' '.date('H:i:s'));
                        $cells->setFont(array(
                            'bold'       =>  true
                        ));
                        $cells->setValignment('center');
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

    private function getOrders($buyer_id,$start_date='',$end_date='',$productTypeNameArr=''){
        $orderList = Order::join('order_status', 'order_status.id', '=', 'orders.order_status');
        $orderList->join('users', 'users.id', '=', 'orders.user_id');
        $orderList->join('order_items', 'order_items.order_id', '=', 'orders.id');
        $orderList->join('product_requests', 'product_requests.id', '=', 'order_items.product_request_id');
        $orderList->join('products', 'products.id', '=', 'product_requests.products_id');
        $orderList->select(DB::raw('orders.*, order_status.status_name,users.users_firstname_th,users.users_lastname_th'));
        $orderList->where('orders.buyer_id', $buyer_id);
        if(!empty($start_date)) {
            $start_date = DateFuncs::convertYear($start_date);
            $orderList->where('orders.order_date', '>=', $start_date);
        }
        if(!empty($end_date)) {
            $end_date = DateFuncs::convertYear($end_date);
            $orderList->where('orders.order_date', '<=', $end_date);
        }
        if(!empty($productTypeNameArr)) {
            $orderList->whereIn('products.id', $productTypeNameArr);
        }
        $orderList->groupBy('orders.id');
        $orderList->orderBy('orders.id', 'DESC');
        $orderList->paginate(config('app.paginate'));
        return $orderLists = $orderList->paginate(config('app.paginate'));
    }

    private function getProductCate($productTypeNameArr){
        return Product::select(DB::raw('products.product_name_th'))
        ->whereIn('products.id', $productTypeNameArr)->get();
    }



}
