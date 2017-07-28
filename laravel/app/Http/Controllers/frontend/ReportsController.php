<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;

use App\Market;
use App\ProductCategory;
use App\ProductRequestMarket;
use DB, Validator, Response,View;
use App\Order;
use Excel;
use Illuminate\Support\Facades\Lang;
use Storage;
use App\OrderPayment;
use App\Product;
use Illuminate\Http\Request;
use App\Helpers\DateFuncs;

//Boots
use App\Http\Controllers\frontend\BaseReportController as BaseReports;

class ReportsController extends BaseReports
{
    private $rules = [
        'start_date' => 'required',
        'end_date' => 'required'
    ];

    public function index(Request $request)
    {
        $user = auth()->guard('user')->user();
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

        $orderList->where('orders.buyer_id', $user->id);
        if (!empty($request->input('productcategorys_id'))) {
            $productcategorys_id = $request->input('productcategorys_id');
            $products = Product::where('productcategory_id', $productcategorys_id)->get();
            $orderList->where('products.productcategory_id', $productcategorys_id);
        }

        if (!empty($request->input('pid'))) {
            $productTypeNameArr = $request->input('pid');
            $orderList->whereIn('products.id', $productTypeNameArr);
        }
        if (!empty($request->input('start_date')) && !empty($request->input('end_date'))) {
            $orderList->whereDate('orders.order_date', '>=', $request->input('start_date'));
            $orderList->whereDate('orders.order_date', '<=', $request->input('end_date'));
            $request['start_date'] = DateFuncs::thai_date($request['start_date']);
            $request['end_date'] = DateFuncs::thai_date($request['end_date']);
            $defult_ymd_last_month = $request->input('start_date');
            $defult_ymd_today = $request->input('end_date');
        } else {
            $defultDateMonthYear = BaseReports::dateToDayAndLastMonth();
            $defult_ymd_last_month = DateFuncs::convertToThaiDate($defultDateMonthYear['ymd_last_month']);
            $defult_ymd_today = DateFuncs::convertToThaiDate($defultDateMonthYear['ymd_today']);
            $orderList->whereDate('orders.order_date', '>=', $defultDateMonthYear['ymd_last_month']);
            $orderList->whereDate('orders.order_date', '<=', $defultDateMonthYear['ymd_today']);
        }
        //$orderList->groupBy('orders.id');
        $orderList->orderBy('orders.order_date', 'DESC');
        $orderList->paginate(config('app.paginate'));
        $orderLists = $orderList->paginate(config('app.paginate'));
        $productCategoryitem = ProductCategory::orderBy('productcategory_title_th', 'ASC')->get();

        return view('frontend.reports.orderlist', compact('orderLists'
            , 'products'
            , 'productTypeNameArr'
            , 'productcategorys_id'
            , 'productCategoryitem'
            , 'defult_ymd_last_month'
            , 'defult_ymd_today'
        ));

    }

    public function actionExportExcel(Request $request)
    {
        if ($request->ajax()) {
            $user = auth()->guard('user')->user();

            $productTypeNameArr = $request->input('product_type_name');
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $buyer_id = $user->id;
            $type = $request->input('type'); // sale or buy
            $productcategorys_id = $request->input('productcategorys_id');
            $orderLists = $this->getOrders($buyer_id, $start_date, $end_date, $productTypeNameArr, $type);

            $productStr = trans('messages.show_all');
            if (!empty($productTypeNameArr)) {
                $res = $this->getProductCate($productTypeNameArr);
                foreach ($res as $re) {
                    $productStrs[] = $re->product_name_th;
                }
                $productStr = implode(",", $productStrs);
            }
            $productcategoryString = trans('validation.attributes.productcategorys_id') . ' : ' . trans('messages.show_all');
            if (!empty($productcategorys_id)) {
                $productcategory = $this->productCategory($productcategorys_id);
                $productcategoryString = trans('validation.attributes.productcategorys_id') . ' : ' . $productcategory->{"productcategory_title_" . Lang::locale()};
            }

            $str_start_and_end_date = trans('messages.text_start_date') . ' : - ' . trans('messages.text_end_date') . ' : -';
            if (!empty($start_date) and !empty($end_date)) {
                $str_start_and_end_date = trans('messages.text_start_date') . ' : ' . $start_date . ' ' . trans('messages.text_end_date') . ' : ' . $end_date;
            }

            if ($type == 'buy') {
                $title_report = trans('messages.menu_order_list');
                $arr[] = array(
                    trans('messages.order_id'),
                    trans('messages.order_date'),
                    trans('messages.order_type'),
                    trans('messages.i_sale'),
                    trans('messages.i_buy'),
                    trans('messages.product_name'),
                    trans('messages.orderbyunit'),
                    trans('messages.order_total') . '(' . trans('messages.baht') . ')',
                    trans('messages.order_status')
                );
            }
            if ($type == 'sale') {
                $title_report = trans('messages.menu_shop_order_list');
                $arr[] = array(
                    trans('messages.order_id'),
                    trans('messages.order_date'),
                    trans('messages.order_type'),
                    trans('messages.i_sale'),
                    trans('messages.i_buy'),
                    trans('messages.product_name'),
                    trans('messages.orderbyunit'),
                    trans('messages.order_total') . '(' . trans('messages.baht') . ')',
                    trans('messages.order_status')
                );
            }

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
                    $v->buyer->users_firstname_th . " " . $v->buyer->users_lastname_th,
                    $v->product_name_th,
                    $v->quantity . ' ' . $v->units,
                    $v->total,
                    $v->status_name
                );
            }
            $data = $arr;
            $info = Excel::create('dgtfarm-orders-buy-excel', function ($excel) use ($data, $productStr, $str_start_and_end_date, $title_report, $productcategoryString) {
                $excel->sheet('Sheetname', function ($sheet) use ($data, $productStr, $str_start_and_end_date, $title_report, $productcategoryString) {
                    $sheet->mergeCells('A1:I1');
                    $sheet->mergeCells('A2:I3');
                    $sheet->mergeCells('A4:I5');
                    $sheet->mergeCells('A6:I7');
                    $sheet->setSize(array(
                        'A1' => array(
                            'height' => 50
                        )
                    ));
                    $sheet->setAutoSize(array('A'));
                    $sheet->cells('A1', function ($cells) use ($title_report) {
                        $cells->setValue($title_report);
                        $cells->setValignment('center');
                        $cells->setAlignment('center');
                        $cells->setFont(array(
                            'size' => '16',
                            'bold' => true
                        ));
                    });
                    $sheet->setColumnFormat(array(
                        'H' => '#,##0'
                    ));

                    $sheet->cells('A2', function ($cells) use ($productcategoryString, $productStr) {
                        $cells->setValue($productcategoryString . ' ' . trans('messages.menu_add_product') . ': ' . $productStr);
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

    public function actionDownload(Request $request)
    {
        $path = storage_path() . '/exports/' . $request->input('file');
        return response()->download($path);
    }

    public function listSale(Request $request)
    {
        $user = auth()->guard('user')->user();
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

        $orderList->where('orders.user_id', $user->id);
        if (!empty($request->input('productcategorys_id'))) {
            $productcategorys_id = $request->input('productcategorys_id');
            $products = Product::where('productcategory_id', $productcategorys_id)->get();
            $orderList->where('products.productcategory_id', $productcategorys_id);
        }

        if (!empty($request->input('pid'))) {
            $productTypeNameArr = $request->input('pid');
            $orderList->whereIn('products.id', $productTypeNameArr);
        }
        if (!empty($request->input('start_date')) && !empty($request->input('end_date'))) {
            $orderList->whereDate('orders.order_date', '>=', $request->input('start_date'));
            $orderList->whereDate('orders.order_date', '<=', $request->input('end_date'));
            $request['start_date'] = DateFuncs::thai_date($request['start_date']);
            $request['end_date'] = DateFuncs::thai_date($request['end_date']);
            $defult_ymd_last_month = $request->input('start_date');
            $defult_ymd_today = $request->input('end_date');
        } else {
            $defultDateMonthYear = BaseReports::dateToDayAndLastMonth();
            $defult_ymd_last_month = DateFuncs::convertToThaiDate($defultDateMonthYear['ymd_last_month']); //get date year thai y-m-d
            $defult_ymd_today = DateFuncs::convertToThaiDate($defultDateMonthYear['ymd_today']); //get date year thai y-m-d
            $orderList->whereDate('orders.order_date', '>=', $defultDateMonthYear['ymd_last_month']);
            $orderList->whereDate('orders.order_date', '<=', $defultDateMonthYear['ymd_today']);
        }

        $orderList->orderBy('orders.order_date', 'DESC');
        $orderList->paginate(config('app.paginate'));
        $orderLists = $orderList->paginate(config('app.paginate'));
        $productCategoryitem = ProductCategory::orderBy('productcategory_title_th', 'ASC')->get();

        return view('frontend.reports.orderlist_sale', compact('orderLists'
            , 'products'
            , 'productTypeNameArr'
            , 'productcategorys_id'
            , 'productCategoryitem'
            , 'defult_ymd_last_month'
            , 'defult_ymd_today'
        ));

    }

    public function SaleItemIndex(Request $request)
    {
        $user = auth()->guard('user')->user();
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

        $orderList = Order::join('order_status', 'order_status.id', '=', 'orders.order_status');
        $orderList->join('users', 'users.id', '=', 'orders.user_id');
        $orderList->join('order_items', 'order_items.order_id', '=', 'orders.id');
        $orderList->join('product_requests', 'product_requests.id', '=', 'order_items.product_request_id');
//        $orderList->join('product_request_market', 'product_request_market.product_request_id', '=', 'product_requests.id');
        $orderList->join('products', 'products.id', '=', 'product_requests.products_id');
        $orderList->select(DB::raw('SUM(order_items.total) as total
            ,product_requests.id as product_requests_id
            ,products.product_name_en
            ,order_status.status_name
            ,users.users_firstname_th
            ,users.users_lastname_th
            ,products.product_name_th
            ,order_items.product_request_id
            ,order_items.quantity
            ,product_requests.units
        '));

        $orderList->where('orders.user_id', $user->id);
        if (!empty($request->input('productcategorys_id'))) {
            $productcategorys_id = $request->input('productcategorys_id');
            $orderList->where('products.productcategory_id', $productcategorys_id);
            $products = Product::where('productcategory_id', $productcategorys_id)->get();
        }

        if (!empty($request->input('pid'))) {
            $productTypeNameArr = $request->input('pid');
            $orderList->whereIn('products.id', $productTypeNameArr);
        }
        if (!empty($request->input('selling_type'))) {
            $selling_type = $request->input('selling_type');
            $orderList->where('orders.order_type', $selling_type);
        }

        if (!empty($request->input('start_date')) && !empty($request->input('end_date'))) {
            $orderList->whereDate('orders.order_date', '>=', $request->input('start_date'));
            $orderList->whereDate('orders.order_date', '<=', $request->input('end_date'));
            $request['start_date'] = DateFuncs::thai_date($request['start_date']);
            $request['end_date'] = DateFuncs::thai_date($request['end_date']);
            $defult_ymd_last_month = $request->input('start_date');
            $defult_ymd_today = $request->input('end_date');
        } else {
            $defultDateMonthYear = BaseReports::dateToDayAndLastMonth();
            $defult_ymd_last_month = DateFuncs::convertToThaiDate($defultDateMonthYear['ymd_last_month']);
            $defult_ymd_today = DateFuncs::convertToThaiDate($defultDateMonthYear['ymd_today']);
            $orderList->whereDate('orders.order_date', '>=', $defultDateMonthYear['ymd_last_month']);
            $orderList->whereDate('orders.order_date', '<=', $defultDateMonthYear['ymd_today']);
        }
        $orderList->where('orders.order_status', '=', 4);
        $orderList->groupBy('products.id');

        $oderList2 = DB::table( DB::raw("({$orderList->toSql()}) as sub") )
            ->mergeBindings($orderList->getQuery()) // you need to get underlying Query Builder
            ->join('product_request_market', 'product_request_market.product_request_id', '=', 'sub.product_requests_id');

        $market_id = '';
        if (!empty($request->input('market_id'))) {
            $market_id = $request->input('market_id');
            $oderList2->where('product_request_market.market_id', $market_id);
        }
        $oderList2->groupBy('sub.product_requests_id');
        $oderList2->orderBy('sub.product_name_th', 'ASC');

        //$orderSaleItem = $orderList->paginate(config('app.paginate'));
        if (!empty($request->input('format_report')) and $request->input('format_report') == 2) {
            $orderSaleItem = $oderList2->paginate(config('app.paginate'));
        } else {
            $orderSaleItem = $oderList2->get();
        }

        $sumAll = 0;
        foreach ($orderSaleItem as $value) {
            $sumAll = $sumAll + $value->total;
        }
        //$productCategoryitem = ProductCategory::all();
        $productCategoryitem = ProductCategory::orderBy('productcategory_title_th', 'ASC')->get();
        $markets = Market::all();

        foreach ($orderSaleItem as $result) {
            $productMarkets = ProductRequestMarket::join('markets', 'product_request_market.market_id', '=', 'markets.id')
                ->select('market_title_th as market_name')
                ->where('product_request_market.product_request_id', $result->product_request_id)
                ->get();
            $result->markets = $productMarkets;
        }

        return view('frontend.reports.sale_item_list', compact('orderSaleItem'
            , 'products'
            , 'productTypeNameArr'
            , 'productcategorys_id'
            , 'sumAll'
            , 'productCategoryitem'
            , 'defult_ymd_last_month'
            , 'defult_ymd_today'
            , 'markets'
            , 'market_id'
        ));

    }

    public function saleItemExportExcel(Request $request)
    {
        if ($request->ajax()) {
            $user = auth()->guard('user')->user();
            $orderList = Order::join('order_status', 'order_status.id', '=', 'orders.order_status');
            $orderList->join('users', 'users.id', '=', 'orders.user_id');
            $orderList->join('order_items', 'order_items.order_id', '=', 'orders.id');
            $orderList->join('product_requests', 'product_requests.id', '=', 'order_items.product_request_id');
            $orderList->join('products', 'products.id', '=', 'product_requests.products_id');
            $orderList->select(DB::raw('SUM(order_items.total) as total
            ,product_requests.id as product_requests_id
            ,products.product_name_th
            ,products.product_name_en
            ,order_status.status_name
            ,users.users_firstname_th
            ,users.users_lastname_th
            ,order_items.product_request_id
            ,order_items.quantity
            ,product_requests.units
        '));

            $orderList->where('orders.user_id', $user->id);
            if (!empty($request->input('start_date'))) {
                $start_date = DateFuncs::convertYear($request->input('start_date'));
                $orderList->whereDate('orders.order_date', '>=', $start_date);
            }
            if (!empty($request->input('end_date'))) {
                $end_date = DateFuncs::convertYear($request->input('end_date'));
                $orderList->whereDate('orders.order_date', '<=', $end_date);
            }
            if (!empty($productTypeNameArr)) {
                $orderList->whereIn('products.id', $productTypeNameArr);
            }
            if (!empty($request->input('selling_type'))) {
                $selling_type = $request->input('selling_type');
                $orderList->where('orders.order_type', $selling_type);
            }

            $orderList->where('orders.order_status', '=', 4);
            $orderList->groupBy('products.id');

            $oderList2 = DB::table( DB::raw("({$orderList->toSql()}) as sub") )
                ->mergeBindings($orderList->getQuery()) // you need to get underlying Query Builder
                ->join('product_request_market', 'product_request_market.product_request_id', '=', 'sub.product_requests_id');

            $market_id = '';
            if (!empty($request->input('market_id'))) {
                $market_id = $request->input('market_id');
                $oderList2->where('product_request_market.market_id', $market_id);
            }
            $oderList2->groupBy('sub.product_requests_id');
            $oderList2->orderBy('sub.product_name_th', 'ASC');
            $orderSaleItem = $oderList2->get();

            $productCategoryitem = ProductCategory::all();
            $markets = Market::all();

            foreach ($orderSaleItem as $result) {
                $productMarkets = ProductRequestMarket::join('markets', 'product_request_market.market_id', '=', 'markets.id')
                    ->select('market_title_th as market_name')
                    ->where('product_request_market.product_request_id', $result->product_request_id)
                    ->get();
                $marketArrStr = array();
                foreach ($productMarkets as $productMarket){
                    array_push($marketArrStr,'- '.$productMarket->market_name);
                }
                $result->markets = implode(", ",$marketArrStr);
            }


            ############## excel #############

            $productStr = trans('messages.show_all');
            if (!empty($productTypeNameArr)) {
                $res = $this->getProductCate($productTypeNameArr);
                foreach ($res as $re) {
                    $productStrs[] = $re->product_name_th;
                }
                $productStr = implode(",", $productStrs);
            }
            $productcategoryString = trans('validation.attributes.productcategorys_id') . ' : ' . trans('messages.show_all');
            if (!empty($productcategorys_id)) {
                $productcategory = $this->productCategory($productcategorys_id);
                $productcategoryString = trans('validation.attributes.productcategorys_id') . ' : ' . $productcategory->{"productcategory_title_" . Lang::locale()};
            }

            $str_start_and_end_date = trans('messages.text_start_date') . ' : - ' . trans('messages.text_end_date') . ' : -';
            if (!empty($start_date) and !empty($end_date)) {
                $str_start_and_end_date = trans('messages.text_start_date') . ' : ' . $start_date . ' ' . trans('messages.text_end_date') . ' : ' . $end_date;
            }

            if (!empty($request->input('selling_type'))) {
                if($request->input('selling_type') == 'retail'){
                    $str_start_and_end_date.= ' '.trans('messages.order_type_sale').' : '.trans('messages.retail');
                }elseif($request->input('selling_type') == 'wholesale'){
                    $str_start_and_end_date.= ' '.trans('messages.order_type_sale').' : '.trans('messages.wholesale');
                }
            }else{
                $str_start_and_end_date.= ' '.trans('messages.order_type_sale').' : '.trans('messages.all');
            }


            // filter market
            $str_market = trans('messages.all');
            if (!empty($user_market)) {
                foreach ($markets as $market) {
                    if ($market->id = $user_market) {
                        $str_market = $market->market_title_th;
                    }
                }
            }


            $title_report = trans('messages.report_title_sale');
            $arr[] = array(
                trans('messages.menu_market'),
                trans('messages.product_name'),
                trans('messages.sum_price_order_type_retail'),
                trans('messages.sum_price_order_type_wholesale'),
                trans('messages.sum_prict_order')
            );


            foreach ($orderSaleItem as $v) {

                $get_order_by_type = DB::table('orders');
                $get_order_by_type->join('order_items', 'orders.id', '=', 'order_items.order_id');
                $get_order_by_type->join('product_requests', 'order_items.product_request_id', '=', 'product_requests.id');
                $get_order_by_type->select(DB::raw('SUM(order_items.total) as total,orders.order_type'));
                $get_order_by_type->where('order_items.product_request_id',  $v->product_requests_id);
                if (!empty($request->input('selling_type'))) {
                    $get_order_by_type->where('orders.order_type', $request->input('selling_type'));
                }
                $get_order_by_type->groupBy('orders.order_type');
                $get_order_by_types = $get_order_by_type->get();

                $retail = 0;
                $wholesale = 0;
                foreach($get_order_by_types as $order_total){
                    if($order_total->order_type == "retail"){
                        if(!empty($order_total->total)){
                            $retail = $order_total->total;
                        }
                    }
                    if($order_total->order_type == "wholesale"){
                        if(!empty($order_total->total)){
                            $wholesale = $order_total->total;
                        }
                    }
                }

                $arr[] = array(
                    $v->markets,
                    $v->product_name_th,
                    //$v->total,
                    $retail,
                    $wholesale,
                    $retail+$wholesale
                );
            }
            $data = $arr;
            $info = Excel::create('dgtfarm-saleitem-excel', function ($excel) use ($data, $productStr, $str_start_and_end_date, $title_report, $productcategoryString,$str_market) {
                $excel->sheet('Sheetname', function ($sheet) use ($data, $productStr, $str_start_and_end_date, $title_report, $productcategoryString,$str_market) {
                    $sheet->mergeCells('A1:E1');
                    $sheet->mergeCells('A2:E3');
                    $sheet->mergeCells('A4:E5');
                    $sheet->mergeCells('A6:E7');
                    $sheet->setSize(array(
                        'A1' => array(
                            'height' => 50
                        )
                    ));
                    $sheet->setAutoSize(array('A'));
                    $sheet->cells('A1', function ($cells) use ($title_report) {
                        $cells->setValue($title_report);
                        $cells->setValignment('center');
                        $cells->setAlignment('center');
                        $cells->setFont(array(
                            'size' => '16',
                            'bold' => true
                        ));
                    });
                    $sheet->setColumnFormat(array(
                        'H' => '#,##0'
                    ));

                    $sheet->cells('A2', function ($cells) use ($str_start_and_end_date) {
                        $cells->setValue($str_start_and_end_date);
                        $cells->setFont(array(
                            'bold' => true
                        ));
                        $cells->setValignment('center');
                    });

                    $sheet->cells('A4', function ($cells) use ($productcategoryString, $productStr,$str_market) {
                        $cells->setValue($productcategoryString . ', ' . trans('messages.menu_add_product') . ': ' . $productStr.", ".trans('messages.menu_market').": ".$str_market);
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

    private function getOrders($buyer_id, $start_date = '', $end_date = '', $productTypeNameArr = '', $type)
    {
        $orderList = Order::join('order_status', 'order_status.id', '=', 'orders.order_status');
        $orderList->join('users', 'users.id', '=', 'orders.user_id');
        $orderList->join('order_items', 'order_items.order_id', '=', 'orders.id');
        $orderList->join('product_requests', 'product_requests.id', '=', 'order_items.product_request_id');
        $orderList->join('product_request_market', 'product_request_market.product_request_id', '=', 'product_requests.id');
        $orderList->join('products', 'products.id', '=', 'product_requests.products_id');
        $orderList->select(DB::raw('orders.*, order_status.status_name
            ,users.users_firstname_th
            ,users.users_lastname_th
            ,products.product_name_th
            ,order_items.quantity
            ,product_requests.units
            ,order_items.total'
        ));

        if ($type == 'sale') {
            $orderList->where('orders.user_id', $buyer_id);
        }
        if ($type == 'buy') {
            $orderList->where('orders.buyer_id', $buyer_id);
        }

        if (!empty($start_date)) {
            $start_date = DateFuncs::convertYear($start_date);
            $orderList->whereDate('orders.order_date', '>=', $start_date);
        }
        if (!empty($end_date)) {
            $end_date = DateFuncs::convertYear($end_date);
            $orderList->whereDate('orders.order_date', '<=', $end_date);
        }
        if (!empty($productTypeNameArr)) {
            $orderList->whereIn('products.id', $productTypeNameArr);
        }
        //$orderList->groupBy('orders.id');
        $orderList->orderBy('orders.order_date', 'DESC');
        return $orderLists = $orderList->get();
    }

    private function getProductCate($productTypeNameArr)
    {
        return Product::select(DB::raw('products.product_name_th'))
            ->whereIn('products.id', $productTypeNameArr)->get();
    }

    private function productCategory($id)
    {
        return ProductCategory::where('productcategorys.id', $id)->first();
    }

    public function getProductByCate($productCateId)
    {
        $products = Product::select(DB::raw('products.id,products.product_name_th'))
            ->where('products.productcategory_id', $productCateId)->get();

        $dataView = View::make('frontend.reports.ele_products')->with('products', $products);
        $dataHtml = $dataView->render();
        return Response::json(array('R'=>'Y','res'=>$dataHtml));
    }


}