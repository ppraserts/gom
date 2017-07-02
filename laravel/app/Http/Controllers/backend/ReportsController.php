<?php

namespace App\Http\Controllers\backend;

use App\OrderItem;
use App\OrderStatusHistory;
use App\ProductCategory;
use App\User;
use Illuminate\Foundation\Validation\ValidatesRequests;
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


class ReportsController extends Controller
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
        $orderLists = '';
        $orderList = Order::join('order_status', 'order_status.id', '=', 'orders.order_status');
        $orderList->join('users', 'users.id', '=', 'orders.user_id');
        $orderList->join('order_items', 'order_items.order_id', '=', 'orders.id');
        $orderList->join('product_requests', 'product_requests.id', '=', 'order_items.product_request_id');
        $orderList->join('products', 'products.id', '=', 'product_requests.products_id');
        $orderList->select(DB::raw('orders.*, order_status.status_name,users.users_firstname_th,users.users_lastname_th'));
//            $orderList->where('orders.buyer_id', $user->id);

        if (!empty($request->input('productcategorys_id'))){
            $productCategoryID = $request->input('productcategorys_id');
            $products = Product::where('productcategory_id',$request->input('productcategorys_id'))->get();
            $orderList->where('products.productcategory_id', $request->input('productcategorys_id'));
        }

        if (!empty($request->input('pid'))) {
            $productTypeNameArr = $request->input('pid');
            $orderList->whereIn('products.id', $productTypeNameArr);
        }
        if (!empty($request->input('start_date')) && !empty($request->input('end_date'))) {
            $orderList->where('orders.order_date', '>=', $request->input('start_date'));
            $orderList->where('orders.order_date', '<=', $request->input('end_date'));
            $request['start_date'] = DateFuncs::thai_date($request['start_date']);
            $request['end_date'] = DateFuncs::thai_date($request['end_date']);
        }
        $orderList->groupBy('orders.id');
        $orderList->orderBy('orders.id', 'DESC');
        $orderLists = $orderList->paginate(config('app.paginate'));
        $productCategoryitem = ProductCategory::all();


//        else{
//            $products = Product::where('productcategory_id',0)->get();
//        }
        return view('backend.reports.orderlist', compact('orderLists', 'products', 'productCategoryID','productTypeNameArr','productCategoryitem'));

    }

    public function actionExportExcel(Request $request)
    {
        if ($request->ajax()) {

            $productTypeNameArr = $request->input('product_type_name');
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $orderLists = $this->ajaxfilter($start_date, $end_date, $productTypeNameArr);

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
                trans('messages.order_type'),
                trans('messages.i_sale'),
                trans('messages.order_date'),
                trans('messages.order_total'),
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
                    $order_type,
                    $v->users_firstname_th . " " . $v->users_lastname_th,
                    $v->order_date,
                    $v->total_amount . trans('messages.baht'),
                    $v->status_name
                );
            }
            $data = $arr;
            $info = Excel::create('dgtfarm-orders-excel', function ($excel) use ($data, $productStr, $str_start_and_end_date) {
                $excel->sheet('Sheetname', function ($sheet) use ($data, $productStr, $str_start_and_end_date) {

                    $sheet->mergeCells('A1:F1');
                    $sheet->mergeCells('A2:F3');
                    $sheet->mergeCells('A4:F5');
                    $sheet->mergeCells('A6:F7');
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

                    $sheet->cells('A2', function ($cells) use ($productStr) {
                        $cells->setValue(trans('messages.menu_add_product') . ': ' . $productStr);
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

        $orderSaleItem = '';

        $orderList = Order::join('order_status', 'order_status.id', '=', 'orders.order_status');
        $orderList->join('users', 'users.id', '=', 'orders.user_id');
        $orderList->join('order_items', 'order_items.order_id', '=', 'orders.id');
        $orderList->join('product_requests', 'product_requests.id', '=', 'order_items.product_request_id');
        $orderList->join('products', 'products.id', '=', 'product_requests.products_id');
        $orderList->select(DB::raw('SUM(orders.total_amount) as total_amounts, products.product_name_th
        , products.product_name_en'));
//            $orderList->where('orders.user_id', $user->id);
        if (!empty($request->input('product_type_name'))) {
            $productTypeNameArr = $request->input('product_type_name');
            $orderList->whereIn('products.id', $productTypeNameArr);
        }
        if (!empty($request->input('start_date')) && !empty($request->input('end_date'))) {
            $orderList->where('orders.order_date', '>=', $request->input('start_date'));
            $orderList->where('orders.order_date', '<=', $request->input('end_date'));
            $request['start_date'] = DateFuncs::thai_date($request['start_date']);
            $request['end_date'] = DateFuncs::thai_date($request['end_date']);
        }
        $orderList->where('orders.order_status', '!=', 5);
        $orderList->groupBy('products.id');
        $orderList->orderBy('orders.id', 'DESC');
        $orderList->paginate(config('app.paginate'));
        $orderSaleItem = $orderList->paginate(config('app.paginate'));
        //products
        $product = Order::join('order_status', 'order_status.id', '=', 'orders.order_status');
        $product->join('users', 'users.id', '=', 'orders.user_id');
        $product->join('order_items', 'order_items.order_id', '=', 'orders.id');
        $product->join('product_requests', 'product_requests.id', '=', 'order_items.product_request_id');
        $product->join('products', 'products.id', '=', 'product_requests.products_id');
        $product->select(DB::raw('products.*'));
//            $product->where('orders.user_id', $user->id);
        $product->orderBy('products.id', 'DESC');
        $products = $product->get();
        //
        $sumAll = 0;
        foreach ($orderSaleItem as $value) {
            $sumAll = $sumAll + $value->total_amounts;
        }
//            return $orderSaleItem;
        return view('backend.reports.sale_item_list', compact('orderSaleItem', 'products', 'productTypeNameArr', 'start_date', 'end_date', 'sumAll'));

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

        $shop_select_arr = $request->input('shop_select_id');
        $shop = User::join('orders', 'orders.user_id', '=', 'users.id');
        $shop->join('shops', 'shops.user_id', '=', 'users.id');
        $shop->select(DB::raw('SUM(orders.total_amount) as total,shops.shop_name,shops.id'));;
        if (!empty($shop_select_arr)) {
            $shop->whereIn('shops.id', $shop_select_arr);
        }
        if (!empty($request->input('start_date')) && !empty($request->input('end_date'))) {
            $shop->where('orders.order_date', '>=', $request->input('start_date'));
            $shop->where('orders.order_date', '<=', $request->input('end_date'));
            $request['start_date'] = DateFuncs::thai_date($request['start_date']);
            $request['end_date'] = DateFuncs::thai_date($request['end_date']);
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
        return view('backend.reports.sale_item_by_shop', compact('shops', 'allShops', 'start_date', 'end_date', 'sumAll'));

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
        $orderList->select(DB::raw('orders.*, order_status.status_name,users.users_firstname_th,users.users_lastname_th'));
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
        $orderList->groupBy('orders.id');
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

}