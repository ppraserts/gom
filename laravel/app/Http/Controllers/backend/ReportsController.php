<?php

namespace App\Http\Controllers\backend;

use App\OrderItem;
use App\OrderStatusHistory;
use App\ProductCategory;
use App\User;
use App\Market;
use App\Http\Controllers\Controller;

use DB, Validator, Response;
use App\Order;
use Excel;
use View;
use Storage;
use App\OrderPayment;
use App\Product;
use Illuminate\Http\Request;
use App\Helpers\DateFuncs;

//Boots
use App\Http\Controllers\backend\BaseReportsController as BaseReports;

class ReportsController extends BaseReports
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    private $rules = [
        'start_date' => 'required',
        'end_date' => 'required|after:start_date'
    ];

    public function index(Request $request)
    {
        if (!empty($request->input('is_search'))) {
            $request['start_date'] = DateFuncs::convertYear($request['start_date']);
            $request['end_date'] = DateFuncs::convertYear($request['end_date']);

            $validator = $this->getValidationFactory()->make($request->all(), $this->rules, [], []);
            if ($validator->fails()) {
                $request['start_date'] = DateFuncs::thai_date($request['start_date']);
                $request['end_date'] = DateFuncs::thai_date($request['end_date']);
                $this->throwValidationException($request, $validator);
            }
        }
        $defultDateMonthYear = BaseReports::dateToDayAndLastMonth();
        //$defultDateMonthYear['ymd_last_month'];
        //$defultDateMonthYear['ymd_today'];

        $orderList = Order::join('order_status', 'order_status.id', '=', 'orders.order_status');
        $orderList->join('users', 'users.id', '=', 'orders.user_id');
        $orderList->join('order_items', 'order_items.order_id', '=', 'orders.id');
        $orderList->join('product_requests', 'product_requests.id', '=', 'order_items.product_request_id');
        $orderList->join('products', 'products.id', '=', 'product_requests.products_id');
        $orderList->select(DB::raw('orders.*, order_status.status_name
            ,users.users_firstname_th
            ,users.users_lastname_th
            ,products.product_name_th
            ,order_items.quantity
            ,product_requests.units
            ,order_items.total'
        ));
//            $orderList->where('orders.buyer_id', $user->id);

        if (!empty($request->input('productcategorys_id'))){
            $productcategorys_id = $request->input('productcategorys_id');
            $products = Product::where('productcategory_id',$productcategorys_id)->get();
            $orderList->where('products.productcategory_id', $productcategorys_id);
        }
        $order_status_id = '';
        if (!empty($request->input('order_status'))){
            $order_status_id = $request->input('order_status');
            $orderList->where('order_status.id',$order_status_id);
        }

        if (!empty($request->input('pid'))) {
            $productTypeNameArr = $request->input('pid');
            $orderList->whereIn('products.id', $productTypeNameArr);
        }
        $defult_ymd_last_month = '';
        $defult_ymd_today = '';
        if (!empty($request->input('start_date')) && !empty($request->input('end_date'))) {
            $orderList->where('orders.order_date', '>=', $request->input('start_date'));
            $orderList->where('orders.order_date', '<=', $request->input('end_date'));
            $request['start_date'] = DateFuncs::thai_date($request['start_date']);
            $request['end_date'] = DateFuncs::thai_date($request['end_date']);
        }else{
            $orderList->where('orders.order_date', '>=', $defultDateMonthYear['ymd_last_month']);
            $orderList->where('orders.order_date', '<=', $defultDateMonthYear['ymd_today']);
            $defult_ymd_last_month = DateFuncs::convertToThaiDate($defultDateMonthYear['ymd_last_month']);
            $defult_ymd_today = DateFuncs::convertToThaiDate($defultDateMonthYear['ymd_today']);
        }
//        $orderList->groupBy('orders.id');
        $orderList->orderBy('orders.id', 'DESC');
        $orderLists = $orderList->paginate(config('app.paginate'));
        $productCategoryitem = ProductCategory::all();

        return view('backend.reports.orderlist', compact('orderLists', 'products'
            ,'productcategorys_id'
            ,'productTypeNameArr'
            ,'productCategoryitem'
            ,'defult_ymd_last_month'
            ,'defult_ymd_today'
            ,'order_status_id'
        ));

    }

    public function actionExportExcel(Request $request)
    {
        if ($request->ajax()) {
            $productTypeNameArr = $request->input('product_type_name');
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $product_category_name = trans('messages.show_all');

            $order_status_name = trans('messages.userstatus').' : '.trans('messages.show_all');
             if(!empty($request->input('order_status'))){
                 $order_status_id = $request->input('order_status');
                 $orderStatu = BaseReports::orderStatus($order_status_id);
                 $order_status_name = trans('messages.userstatus').' : '.$orderStatu->status_name;
             }

            if(!empty($request->input('productcategorys_id'))){
                $productcategorys_id = $request->input('productcategorys_id');
                $product_category = BaseReports::productCategory($productcategorys_id);
                $product_category_name = $product_category->productcategory_title_th;
            }

            $orderLists = $this->ajaxfilter($start_date, $end_date, $productTypeNameArr);

            $gropProduct = trans('validation.attributes.productcategorys_id').' : '.$product_category_name;

            $productStr = trans('messages.show_all');
            if (!empty($productTypeNameArr)) {
                $res = $this->getProductCate($productTypeNameArr);
                foreach ($res as $re) {
                    $productStrs[] = $re->product_name_th;
                }
                $productStr = implode(",", $productStrs);
            }
            $str_start_and_end_date = trans('messages.text_start_date') . ' : - ' . trans('messages.text_end_date') . ' : -';
            if (!empty($start_date) and !empty($end_date)) {
                $str_start_and_end_date = trans('messages.text_start_date') . ' : ' . $start_date . ' ' . trans('messages.text_end_date') . ' : ' . $end_date;
            }

            $arr[] = array(
                trans('messages.order_id'),
                trans('messages.order_date'),
                trans('messages.order_type'),
                trans('messages.i_sale'),
                trans('messages.product_name'),
                trans('messages.orderbyunit'),
                trans('messages.order_total').'('.trans('messages.baht').')',
                trans('messages.order_status')
            );
            foreach ($orderLists as $v) {
                if ($v->order_type == 'retail') {
                    $order_type = trans('messages.retail');
                } else {
                    $order_type = trans('messages.wholesale');
                }
                $arr[] = array(
                    $v->id,
                    DateFuncs::dateToThaiDate($v->order_date),
                    $order_type,
                    $v->users_firstname_th . " " . $v->users_lastname_th,
                    $v->product_name_th,
                    $v->quantity.' '.$v->units,
                    $v->total,
                    $v->status_name
                );
            }
            $data = $arr;
            $info = Excel::create('dgtfarm-orders-excel', function ($excel) use ($data, $productStr,$gropProduct, $str_start_and_end_date,$order_status_name) {
                $excel->sheet('Sheetname', function ($sheet) use ($data, $productStr,$gropProduct, $str_start_and_end_date,$order_status_name) {

                    $sheet->mergeCells('A1:H1');
                    $sheet->mergeCells('A2:H3');
                    $sheet->mergeCells('A4:H5');
                    $sheet->mergeCells('A6:H7');
                    $sheet->setSize(array(
                        'A1' => array(
                            'height' => 50
                        )
                    ));
                    $sheet->setAutoSize(array('A'));
                    $sheet->cells('A1', function ($cells) {
                        $cells->setValue(trans('messages.menu_order_list'));
                        $cells->setValignment('center');
                        $cells->setAlignment('center');
                        $cells->setFont(array(
                            'size' => '16',
                            'bold' => true
                        ));
                    });

                    $sheet->cells('A2', function ($cells) use ($order_status_name,$gropProduct,$productStr) {
                        $cells->setValue($order_status_name.' '.$gropProduct.' '.trans('messages.menu_add_product') . ': ' . $productStr);
                        $cells->setFont(array(
                            'bold' => true
                        ));
                        $cells->setValignment('center');
                    });
                    $sheet->cells('A4', function ($cells) use ($str_start_and_end_date) {
                        $cells->setValue($str_start_and_end_date);
                        $cells->setFont(array(
                            'bold' => true
                        ));
                        $cells->setValignment('center');
                    });
                    $sheet->cells('A6', function ($cells) {
                        $cells->setValue(trans('messages.datetime_export') . ': ' . DateFuncs::convertToThaiDate(date('Y-m-d')) . ' ' . date('H:i:s'));
                        $cells->setFont(array(
                            'bold' => true
                        ));
                        $cells->setValignment('center');
                    });

                    $sheet->rows($data);
                });
            })->store('xls', false, true);
            return response()->json(array('file' => $info['file']));
        }
    }

    public function saleExportExcel(Request $request)
    {
        if ($request->ajax()) {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $market_id = $request->input('market_id');
            $productcategorys_id = $request->input('productcategorys_id');
            $product_id_arr = $request->input('product_type_name');

            $market_name =  trans('messages.menu_market').' : '.trans('messages.show_all');
            $productcategorys_name = trans('validation.attributes.productcategorys_id').' : '.trans('messages.show_all');
            $product_name = trans('messages.menu_add_product').' : '.trans('messages.show_all');

            if(!empty($market_id)){
                $market = BaseReports::market($market_id);
                $market_name = trans('messages.menu_market').' : '.$market->market_title_th;
            }

            if(!empty($productcategorys_id)){
                $product_category = BaseReports::productCategory($productcategorys_id);
                $productcategorys_name = trans('messages.menu_add_product').' : '.$product_category->productcategory_title_th;
            }

            if(count($product_id_arr) > 0 and !empty($product_id_arr)){
                $products = BaseReports::products($product_id_arr);
                foreach ($products as $product){
                    $arrProduct[] = $product->product_name_th;
                }
                $product_name = trans('messages.menu_add_product').' : '. implode(",",$arrProduct);
            }

           $orderLists =  $this->saleFilterExport($start_date,$end_date,$market_id,$productcategorys_id,$product_id_arr);

            $product_name_arr = $product_name;
            $str_start_and_end_date = trans('messages.text_start_date') . ' : - ' . trans('messages.text_end_date') . ' : -';
            if (!empty($start_date) and !empty($end_date)) {
                $str_start_and_end_date = trans('messages.text_start_date') . ' : ' . $start_date . ' ' . trans('messages.text_end_date') . ' : ' . $end_date;
            }

            $arr[] = array(
                trans('messages.order_id'),
                trans('messages.order_date'),
                trans('messages.order_type'),
                trans('messages.menu_market'),
                trans('messages.menu_add_product'),
                trans('messages.orderbyunit'),
                trans('messages.i_sale'),
                trans('messages.i_buy'),
                trans('messages.order_total').'('.trans('messages.baht').')',
                trans('messages.order_status')
            );

            foreach ($orderLists as $v) {
                if ($v->order_type == 'retail') {
                    $order_type = trans('messages.retail');
                } else {
                    $order_type = trans('messages.wholesale');
                }
                $arr[] = array(
                    $v->id,
                    DateFuncs::dateToThaiDate($v->order_date),
                    $order_type,
                    $v->market_title_th,
                    $v->product_name_th,
                    $v->quantity.' '.$v->units,
                    $v->users_firstname_th . " " . $v->users_lastname_th,
                    $v->buyer->users_firstname_th . " " . $v->buyer->users_lastname_th,
                    $v->total,
                    $v->status_name
                );
            }
            $data = $arr;
            $info = Excel::create('dgtfarm-orders-sale-excel', function ($excel) use ($data,$str_start_and_end_date,$market_name,$productcategorys_name,$product_name_arr) {
                $excel->sheet('Sheetname', function ($sheet) use ($data,$str_start_and_end_date,$market_name,$productcategorys_name,$product_name_arr) {

                    $sheet->mergeCells('A1:J1');
                    $sheet->mergeCells('A2:J3');
                    $sheet->mergeCells('A4:J5');
                    $sheet->mergeCells('A6:J7');
                    $sheet->setSize(array(
                        'A1' => array(
                            'height' => 50
                        )
                    ));
                    $sheet->setAutoSize(array('A'));
                    $sheet->cells('A1', function ($cells) {
                        $cells->setValue(trans('messages.report_title_sale'));
                        $cells->setValignment('center');
                        $cells->setAlignment('center');
                        $cells->setFont(array(
                            'size' => '16',
                            'bold' => true
                        ));
                    });

                    $sheet->cells('A2', function ($cells) use ($str_start_and_end_date) {
                        $cells->setValue($str_start_and_end_date);
                        $cells->setFont(array(
                            'bold' => true
                        ));
                        $cells->setValignment('center');
                    });

                    $sheet->cells('A4', function ($cells) use ($market_name,$productcategorys_name,$product_name_arr) {
                        $cells->setValue($market_name.' '.$productcategorys_name.' '.$product_name_arr);
                        $cells->setFont(array(
                            'bold' => true
                        ));
                        $cells->setValignment('center');
                    });

                    $sheet->cells('A6', function ($cells) {
                        $cells->setValue(trans('messages.datetime_export') . ': ' . DateFuncs::convertToThaiDate(date('Y-m-d')) . ' ' . date('H:i:s'));
                        $cells->setFont(array(
                            'bold' => true
                        ));
                        $cells->setValignment('center');
                    });

                    $sheet->rows($data);
                });
            })->store('xls', false, true);
            return response()->json(array('file' => $info['file']));
        }
    }

    public function actionDownload(Request $request)
    {
        $path = storage_path() . '/exports/' . $request->input('file');
        return response()->download($path);
    }

    public function SaleItemIndex(Request $request)
    {

        if (!empty($request->input('is_search'))) {

            $request['start_date'] = DateFuncs::convertYear($request['start_date']);
            $request['end_date'] = DateFuncs::convertYear($request['end_date']);

            $validator = $this->getValidationFactory()->make($request->all(), $this->rules, [], []);
            if ($validator->fails()) {
                $request['start_date'] = DateFuncs::thai_date($request['start_date']);
                $request['end_date'] = DateFuncs::thai_date($request['end_date']);
                $this->throwValidationException($request, $validator);
            }
        }

        $defultDateMonthYear = BaseReports::dateToDayAndLastMonth();

        $orderList = Order::join('order_status', 'order_status.id', '=', 'orders.order_status');
        $orderList->join('users', 'users.id', '=', 'orders.user_id');
        $orderList->join('user_market', 'user_market.user_id', '=', 'users.id');
        $orderList->join('markets', 'markets.id', '=', 'user_market.market_id');
        $orderList->join('order_items', 'order_items.order_id', '=', 'orders.id');
        $orderList->join('product_requests', 'product_requests.id', '=', 'order_items.product_request_id');
        $orderList->join('products', 'products.id', '=', 'product_requests.products_id');
        if (empty($request->input('format_report')) or $request->input('format_report') == 1) {
            $orderList->select(DB::raw('orders.*,SUM(orders.total_amount) as total_amounts
            ,products.product_name_th
            ,products.product_name_en
            ,markets.market_title_th
            ,order_status.status_name
            ,users.users_firstname_th
            ,users.users_lastname_th
            '));
        }elseif(!empty($request->input('format_report')) or $request->input('format_report') == 2) {
            $orderList->select(DB::raw('orders.*
            ,products.product_name_th
            ,products.product_name_en
            ,markets.market_title_th
            ,order_status.status_name
            ,users.users_firstname_th
            ,users.users_lastname_th
            ,order_items.quantity
            ,product_requests.units
            ,order_items.total
            '));
        }
//            $orderList->where('orders.user_id', $user->id);
        if (!empty($request->input('productcategorys_id'))){
            $productcategorys_id = $request->input('productcategorys_id');
            $orderList->where('products.productcategory_id', $productcategorys_id);
            $products = Product::where('productcategory_id',$productcategorys_id)->get();
        }

        if (!empty($request->input('pid'))) {
            $productTypeNameArr = $request->input('pid');
            $orderList->whereIn('products.id', $productTypeNameArr);
        }
        $market_id = '';
        if (!empty($request->input('market_id'))) {
            $market_id = $request->input('market_id');
            $orderList->where('markets.id', $market_id);
        }

        $defult_ymd_last_month='';
        $defult_ymd_today='';
        if (!empty($request->input('start_date')) && !empty($request->input('end_date'))) {
            $orderList->where('orders.order_date', '>=', $request->input('start_date'));
            $orderList->where('orders.order_date', '<=', $request->input('end_date'));
            $request['start_date'] = DateFuncs::thai_date($request['start_date']);
            $request['end_date'] = DateFuncs::thai_date($request['end_date']);
        }else{
            $orderList->where('orders.order_date', '>=', $defultDateMonthYear['ymd_last_month']);
            $orderList->where('orders.order_date', '<=', $defultDateMonthYear['ymd_today']);
            $defult_ymd_last_month = DateFuncs::convertToThaiDate($defultDateMonthYear['ymd_last_month']);
            $defult_ymd_today = DateFuncs::convertToThaiDate($defultDateMonthYear['ymd_today']);
        }
        $orderList->where('orders.order_status', '!=', 5);
        if (empty($request->input('format_report')) or $request->input('format_report') == 1) {
            $orderList->groupBy('products.id');
        }
        $orderList->orderBy('orders.id', 'DESC');
        if (!empty($request->input('format_report')) and $request->input('format_report') == 2) {
            $orderSaleItem = $orderList->paginate(config('app.paginate'));
        }else{
            $orderSaleItem = $orderList->get();
        }

        $productCategoryitem = ProductCategory::all();
        $markets = Market::all();
        //
        $sumAll = 0;
        foreach ($orderSaleItem as $value) {
            $sumAll = $sumAll + $value->total_amounts;
        }
        //return $orderSaleItem;
        return view('backend.reports.sale_item_list', compact('orderSaleItem'
            ,'productCategoryitem'
            ,'productcategorys_id'
            ,'products'
            ,'productTypeNameArr'
            ,'sumAll'
            ,'defult_ymd_last_month'
            ,'defult_ymd_today'
            ,'markets'
            ,'market_id'
        ));

    }

    public function SaleItemByShop(Request $request)
    {
        if (!empty($request->input('is_search'))) {

            $request['start_date'] = DateFuncs::convertYear($request['start_date']);
            $request['end_date'] = DateFuncs::convertYear($request['end_date']);

            $validator = $this->getValidationFactory()->make($request->all(), $this->rules, [], []);
            if ($validator->fails()) {
                $request['start_date'] = DateFuncs::thai_date($request['start_date']);
                $request['end_date'] = DateFuncs::thai_date($request['end_date']);
                $this->throwValidationException($request, $validator);
            }
        }
        $defultDateMonthYear = BaseReports::dateToDayAndLastMonth();
        $shop_select_arr = $request->input('shop_select_id');
        $shop = User::join('orders', 'orders.user_id', '=', 'users.id');
        $shop->join('shops', 'shops.user_id', '=', 'users.id');
        $shop->select(DB::raw('SUM(orders.total_amount) as total,shops.shop_name,shops.id'));;
        if (!empty($shop_select_arr)) {
            $shop->whereIn('shops.id', $shop_select_arr);
        }
        $defult_ymd_last_month='';
        $defult_ymd_today='';
        if (!empty($request->input('start_date')) && !empty($request->input('end_date'))) {
            $shop->where('orders.order_date', '>=', $request->input('start_date'));
            $shop->where('orders.order_date', '<=', $request->input('end_date'));
            $request['start_date'] = DateFuncs::thai_date($request['start_date']);
            $request['end_date'] = DateFuncs::thai_date($request['end_date']);
        }else{
            $shop->where('orders.order_date', '>=', $defultDateMonthYear['ymd_last_month']);
            $shop->where('orders.order_date', '<=', $defultDateMonthYear['ymd_today']);
            $defult_ymd_last_month = DateFuncs::convertToThaiDate($defultDateMonthYear['ymd_last_month']);
            $defult_ymd_today = DateFuncs::convertToThaiDate($defultDateMonthYear['ymd_today']);
        }
        $shop->groupBy('shops.id');
        $shop->orderBy('total', 'DESC');
        $shops = $shop->get();;

        $sumAll = 0;
        foreach ($shops as $value) {
            $sumAll = $sumAll + $value->total;
        }

        $allShops = User::join('orders', 'orders.user_id', '=', 'users.id')
            ->join('shops', 'shops.user_id', '=', 'users.id')
            ->select('shops.*')
            ->groupBy('shops.id')
            ->get();
//            return $shopsList;
        return view('backend.reports.sale_item_by_shop',
            compact('shops', 'allShops', 'start_date', 'end_date', 'sumAll','defult_ymd_last_month','defult_ymd_today'));

    }

    public function orderdetail(Request $request, $order_id)
    {
//        $user = auth()->guard('user')->user();
        $orderType = $request->input('status');
        if (!empty($orderType)) {
            Session::put('orderType', $orderType);
        }
        $orderId = $order_id;
        $order = Order::join('order_status', 'order_status.id', '=', 'orders.order_status')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->select('orders.*', 'order_status.status_name', 'order_status.id as orderStatusId', 'users.users_firstname_th', 'users.users_lastname_th', 'users.id as userId')
            ->where('orders.id', $order_id)->first();
//        $order->orderItems = OrderItem::with(['product','productRequest'])->where('order_id',$order_id)->get();
        $orderItem = new OrderItem();
        $order->orderItems = $orderItem->orderItemDetail($order_id);
        $order->statusHistory = OrderStatusHistory::where('order_id', $order_id)->get();
        //return $order;

//        $user = auth()->guard('user')->user();
//        $userId = $user->id;
        //return $order;
        return view('backend.orderdetail', compact('order', 'orderId'));
    }

    private function ajaxfilter($start_date = '', $end_date = '', $productTypeNameArr = '')
    {
        $orderList = Order::join('order_status', 'order_status.id', '=', 'orders.order_status');
        $orderList->join('users', 'users.id', '=', 'orders.user_id');
        $orderList->join('order_items', 'order_items.order_id', '=', 'orders.id');
        $orderList->join('product_requests', 'product_requests.id', '=', 'order_items.product_request_id');
        $orderList->join('products', 'products.id', '=', 'product_requests.products_id');
        $orderList->select(DB::raw('orders.*, order_status.status_name
            ,users.users_firstname_th
            ,users.users_lastname_th
            ,products.product_name_th
            ,order_items.quantity
            ,product_requests.units
            ,order_items.total'
        ));
        if (!empty($start_date)) {
            $start_date = DateFuncs::convertYear($start_date);
            $orderList->where('orders.order_date', '>=', $start_date);
        }
        if (!empty($end_date)) {
            $end_date = DateFuncs::convertYear($end_date);
            $orderList->where('orders.order_date', '<=', $end_date);
        }
        if (!empty($productTypeNameArr)) {
            $productTypeNameArr = $productTypeNameArr;
            $orderList->whereIn('products.id', $productTypeNameArr);
        }
//        $orderList->groupBy('orders.id');
        $orderList->orderBy('orders.id', 'DESC');
//        $orderLists = $orderList->get();
        return $orderLists = $orderList->get();
    }

    private function getProductCate($productTypeNameArr)
    {
        return Product::select(DB::raw('products.product_name_th'))
            ->whereIn('products.id', $productTypeNameArr)->get();
    }

    public function getProductByCate($productCateId)
    {
        $products = Product::select(DB::raw('products.id,products.product_name_th'))
            ->where('products.productcategory_id', $productCateId)->get();

        $dataView = View::make('backend.reports.ele_products')->with('products', $products);
        $dataHtml = $dataView->render();
        return Response::json(array('R'=>'Y','res'=>$dataHtml));
    }

    private function saleFilterExport($date_start,$date_end,$market_id='',$productcategorys_id='',$product_id_arr = array()){
        $orderList = Order::join('order_status', 'order_status.id', '=', 'orders.order_status');
        $orderList->join('users', 'users.id', '=', 'orders.user_id');
        $orderList->join('user_market', 'user_market.user_id', '=', 'users.id');
        $orderList->join('markets', 'markets.id', '=', 'user_market.market_id');
        $orderList->join('order_items', 'order_items.order_id', '=', 'orders.id');
        $orderList->join('product_requests', 'product_requests.id', '=', 'order_items.product_request_id');
        $orderList->join('products', 'products.id', '=', 'product_requests.products_id');
        $orderList->select(DB::raw('orders.*
            ,products.product_name_th
            ,products.product_name_en
            ,markets.market_title_th
            ,order_status.status_name
            ,users.users_firstname_th
            ,users.users_lastname_th
            ,order_items.quantity
            ,product_requests.units
            ,order_items.total
            '));
        if (!empty($date_start) and !empty($date_end)) {
            $date_start = DateFuncs::convertYear($date_start);
            $date_end = DateFuncs::convertYear($date_end);
            $orderList->where('orders.order_date', '>=', $date_start);
            $orderList->where('orders.order_date', '<=', $date_end);
        }

        if (!empty($productcategorys_id)){
            $orderList->where('products.productcategory_id', $productcategorys_id);
        }
        if (!empty($market_id)){
            $orderList->where('markets.id',$market_id);
        }

        if (count($product_id_arr) > 0) {
            $orderList->whereIn('products.id', $product_id_arr);
        }

        $orderList->orderBy('orders.id', 'DESC');
        return $orderLists = $orderList->get();

    }

}