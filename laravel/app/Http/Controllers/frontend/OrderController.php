<?php

namespace App\Http\Controllers\frontend;
use PDF;
use DB,Response,Validator;
use App\Order;
use App\OrderItem;
use App\Shop;
use App\ProductRequest;
use App\ShopDelivery;
use App\OrderDelivery;
use Session;
use App\OrderStatusHistory;
use App\OrderPayment;
use Illuminate\Http\Request;
use App\Helpers\DateFuncs;

//use App\Http\Controllers\Controller;

//Boots
use App\Http\Controllers\frontend\SystemsController as Systems;
class OrderController extends Systems
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
        if(!empty($request->input('filter'))){
            $filter = $request->input('filter');
            $orderList = \App\Order::join('order_status', 'order_status.id', '=', 'orders.order_status')
                ->join('users', 'users.id', '=', 'orders.buyer_id')
                ->select('orders.*', 'order_status.status_name', 'users.users_firstname_th', 'users.users_lastname_th')
                ->where('orders.user_id', $user->id)
                ->where(function($query) use ($filter) {
                    $query->where('orders.id', 'like', '%' . $filter . '%');
                    $query->orWhere('users.users_firstname_th', 'like', '%' . $filter . '%');
                    $query->orWhere('order_status.status_name', 'like', '%' . $filter . '%');
                })
                ->orderBy('orders.id', 'DESC')
                ->paginate(config('app.paginate'));
        }else {
            $orderList = \App\Order::join('order_status', 'order_status.id', '=', 'orders.order_status')
                ->join('users', 'users.id', '=', 'orders.buyer_id')
                ->select('orders.*', 'order_status.status_name', 'users.users_firstname_th', 'users.users_lastname_th')
                ->where('orders.user_id', $user->id)
                ->orderBy('orders.id', 'DESC')
                ->paginate(config('app.paginate'));
        }

        $data = array('user_id' => $user->id,
            'i' => ($request->input('page', 1) - 1) * config('app.paginate'));
        return view('frontend.shoporder', compact('orderList'))
            ->with($data);
    }

    public function orderdetail(Request $request,$order_id){
//        $user = auth()->guard('user')->user();
        $orderType = $request->input('status');
        if(!empty($orderType)){
            Session::put('orderType',$orderType);
        }
        $orderId = $order_id;
        $order = Order::join('order_status', 'order_status.id', '=', 'orders.order_status')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->select('orders.*', 'order_status.status_name','order_status.id as orderStatusId','users.users_firstname_th','users.users_lastname_th','users.id as userId')
            ->where('orders.id', $order_id)->first();
//        $order->orderItems = OrderItem::with(['product','productRequest'])->where('order_id',$order_id)->get();
        //return $order;
        $orderItem = new OrderItem();
        $order->orderItems = $orderItem->orderItemDetail($order_id);
        $order->statusHistory = OrderStatusHistory::where('order_id',$order_id)->get();
        //return $order;

//        $user = auth()->guard('user')->user();
//        $userId = $user->id;
        //return $order;
        $shopdeliverys = ShopDelivery::all();
        $orderDeliverys = OrderDelivery::where('order_id',$order_id)->get();
        $order_delivery = OrderDelivery::where('order_id',$order_id)->where('user_buy_id','!=',0)->first();
        return view('frontend.orderdetail', compact('order','orderId','shopdeliverys','orderDeliverys','order_delivery'));
    }

    public function exportPdf(Request $request,$order_id){
        $orderType = $request->input('status');
        if(!empty($orderType)){
            Session::put('orderType',$orderType);
        }

        $order = Order::join('order_status', 'order_status.id', '=', 'orders.order_status')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->select('orders.*', 'order_status.status_name','order_status.id as orderStatusId','users.users_firstname_th','users.users_lastname_th','users.id as userId')
            ->where('orders.id', $order_id)->first();
//        $order->orderItems = OrderItem::with(['product','productRequest'])->where('order_id',$order_id)->get();
        $orderItem = new OrderItem();
        $order->orderItems = $orderItem->orderItemDetail($order_id);
        $order->statusHistory = OrderStatusHistory::where('order_id',$order_id)->get();

        $data['order'] = $order;
        $pdf = PDF::loadView('pdf.orderdetail', $data);
        //$pdf->setPaper('legal', 'landscape');
        //return $pdf->stream();
        //return view('pdf.orderdetail', $data);
        return $pdf->download('order-'.$order->id.'.pdf');
    }

    public function getHtmlConfirmSale(Request $request, $confirm_sale_type = ''){
        if($request->ajax()){
            if(!empty($confirm_sale_type) and $confirm_sale_type == 1){
                $user = auth()->guard('user')->user();
                $shop = Shop::where('user_id', $user->id)->first();
                $view_ele =  view('frontend.order_element.payment_channel',compact('shop'));
                $dataHtml = $view_ele->render();
                return Response::json(array('r' => 'Y', 'data_html' => $dataHtml));
            }
        }
        return view('errors.404');
    }


    public  function storeStatusHistory(Request $request)
    {
        //return $request->all();
        $user = auth()->guard('user')->user();
        $userId = $user->id;
        $order_id = $request->input('order_id');
        /*********************************/
        $selectedArr = $request->input('selected');
        $shipping_channel_arr = $request->input('shipping_channel');
        $delivery_charge_arr = $request->input('delivery_charge');
        $sum_delivery_price = $request->input('sum_delivery_price');



        $order_delivery_arr = array();
        if(count($shipping_channel_arr) > 0) {
            $num_i =1;
            foreach ($shipping_channel_arr as $key => $shipping_channel) {
                $selected = 0;
                if (in_array($key, $selectedArr)){
                    $selected = 1;
                }
                $order_delivery_arr[] = array(
                    $shipping_channel, $delivery_charge_arr[$key], $sum_delivery_price[$key], $selected
                );
                $num_i++;
            }
        }
        if(count($order_delivery_arr) > 0){
            foreach ($order_delivery_arr as $order_delivery){
                $orderDelivery = new OrderDelivery();
                //$orderDelivery->user_buy_id = '';
                $orderDelivery->user_sale_id = $userId;
                $orderDelivery->order_id = $order_id;
                $orderDelivery->shipping_channel = $order_delivery[0];
                $orderDelivery->delivery_charge = $order_delivery[1];
                $orderDelivery->sum_delivery_charge = $order_delivery[2];
                $orderDelivery->selected = $order_delivery[3];
                $orderDelivery->save();
            }
        }



        $status_current = $request->input('status_current');
        $note = $request->input('note');

        if ($status_current == 2) {

            //$payment_channel = $request->input('payment_channel');
            //insert status ยืนยันการสั่งซื้อ
            $status_id = 2;
            $status_text = 'ยืนยันการสั่งซื้อ';
            $orderStatusHistory = new OrderStatusHistory();
            $orderStatusHistory->status_id = $status_id;
            $orderStatusHistory->status_text = $status_text;
//            if (!empty($payment_channel) and  $payment_channel == 'เงินสด') {
//                $orderStatusHistory->note = $note;
//            }
            //$orderStatusHistory->note = $note;
            $orderStatusHistory->order_id = $order_id;
            $orderStatusHistory->save();
            $order['order_status'] = $status_id;
            Order::find($order_id)->update($order);

            //if (!empty($payment_channel) and $payment_channel == 'บัญชีธนาคาร'){
                //insert status แจ้งช่องทางการชำระเงิน
                $status_id = 6;
                $status_text = 'แจ้งช่องทางการชำระเงิน';
                $orderStatusHistory = new OrderStatusHistory();
                $orderStatusHistory->status_id = $status_id;
                $orderStatusHistory->status_text = $status_text;
                $orderStatusHistory->note = $note;
                $orderStatusHistory->order_id = $order_id;
                $orderStatusHistory->save();
                //insert status รอชำระเงิน
                $status_id = 7;
                $status_text = 'รอชำระเงิน';
                $orderStatusHistory = new OrderStatusHistory();
                $orderStatusHistory->status_id = $status_id;
                $orderStatusHistory->status_text = $status_text;
                //$orderStatusHistory->note = $note;
                $orderStatusHistory->order_id = $order_id;
                $orderStatusHistory->save();


            //}

            return redirect('user/orderdetail/'.$order_id);
        }
        if ($status_current == 6) {
            //insert status แจ้งช่องทางการชำระเงิน
            $status_id = 6;
            $status_text = 'แจ้งช่องทางการชำระเงิน';
            $orderStatusHistory = new OrderStatusHistory();
            $orderStatusHistory->status_id = $status_id;
            $orderStatusHistory->status_text = $status_text;
            $orderStatusHistory->note = $note;
            $orderStatusHistory->order_id = $order_id;
            $orderStatusHistory->save();
            //insert status รอชำระเงิน
            $status_id = 7;
            $status_text = 'รอชำระเงิน';
            $orderStatusHistory = new OrderStatusHistory();
            $orderStatusHistory->status_id = $status_id;
            $orderStatusHistory->status_text = $status_text;
            //$orderStatusHistory->note = $note;
            $orderStatusHistory->order_id = $order_id;
            $orderStatusHistory->save();
            return redirect('user/orderdetail/'.$order_id);
        }

        if ($status_current == 3) {
            //upload file payment
            $part_directory = config('app.upload_payment');
            $image = $_FILES["payment_image"];
            $image_name = '';
            if(!empty($image['size'] > 0)){
                $upload = Systems::uploadPaymentImage($image,$part_directory);
                if ($upload == 'errors') {
                    Session::flash('flash_message','Allow a specific extension, only *.jpg , *.png, *.pdf, *.docx, *.xlsx');
                    return redirect('user/orderdetail/'.$order_id);
                } else {
                    $image_name = $upload;
                }
            }

            //save OrderStatusHistory
            $status_id = 3;
            $status_text = 'แจ้งชำระเงิน';
            $orderStatusHistory = new OrderStatusHistory();
            $orderStatusHistory->status_id = $status_id;
            $orderStatusHistory->status_text = $status_text;
            $orderStatusHistory->note = $note;
            $orderStatusHistory->order_id = $order_id;
            if(!empty($image_name)){
                $orderStatusHistory->image_payment_url = $image_name;
            }
            $orderStatusHistory->save();

            $order['order_status'] = $status_id;
            Order::find($order_id)->update($order);

            $status_id = 8;
            $status_text = 'รอการจัดส่ง';
            $orderStatusHistory = new OrderStatusHistory();
            $orderStatusHistory->status_id = $status_id;
            $orderStatusHistory->status_text = $status_text;
//            $orderStatusHistory->note = $note;
            $orderStatusHistory->order_id = $order_id;
            $orderStatusHistory->save();

            //update OrderDelivery
            if(!empty($request->input('user_buy_id'))){
                $order_delivery_id = $request->input('user_buy_id');
                $data_order_delivery['user_buy_id'] = $order_delivery_id;
                OrderDelivery::find($order_delivery_id)->update($data_order_delivery);
            }

            return redirect('user/orderdetail/'.$order_id);
        }

        if ($status_current == 4) {
            //upload file image
            $part_directory = config('app.upload_payment');
            $image = $_FILES["delivery_image"];
            $image_name = '';
            if(!empty($image['size'] > 0)){
                $upload = Systems::uploadPaymentImage($image,$part_directory);
                if ($upload == 'errors') {
                    Session::flash('flash_message','Allow a specific extension, only *.jpg , *.png, *.pdf, *.docx, *.xlsx');
                    return redirect('user/orderdetail/'.$order_id);
                } else {
                    $image_name = $upload;
                }
            }

            $checkOrder = Order::join('order_status', 'order_status.id', '=', 'orders.order_status')
                ->join('users', 'users.id', '=', 'orders.user_id')
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->join('product_requests', 'order_items.product_request_id', '=', 'product_requests.id')
                ->select('orders.*', 'order_status.status_name','order_status.id as orderStatusId',
                    'users.users_firstname_th','users.users_lastname_th','users.id as userId','order_items.quantity',
                    'product_requests.id as product_requestId','product_requests.product_stock','product_requests.product_title')
                ->where('orders.id', $order_id)->get();

            if(count($checkOrder) > 0) {
                foreach ($checkOrder as $val) {
                    if ($val->product_stock >= $val->quantity) {
                        $qty = $val->product_stock - $val->quantity;
                        $data['product_stock'] = $qty;
                        ProductRequest::where('id', $val->product_requestId)->update($data);
                    }else if ($val->product_stock != 0 and  $val->product_stock < $val->quantity) {
                        $data['product_stock'] = 0;
                        ProductRequest::where('id', $val->product_requestId)->update($data);
                    }
                }
            }

            $status_id = 4;
            $status_text = 'จัดส่งแล้ว';
            $delivery_chanel = $request->input('delivery_chanel');
            $order_date = DateFuncs::convertYear($request->input('order_date'));

            $orderStatusHistory = new OrderStatusHistory();
            $orderStatusHistory->status_id = $status_id;
            $orderStatusHistory->status_text = $status_text;
            $orderStatusHistory->note = $note;
            $orderStatusHistory->order_id = $order_id;
            $orderStatusHistory->delivery_chanel = $delivery_chanel;
            $orderStatusHistory->order_date = $order_date;
            if(!empty($image_name)){
                $orderStatusHistory->image_payment_url = $image_name;
            }
            $orderStatusHistory->save();


            $order['order_status'] = $status_id;
            Order::find($order_id)->update($order);
            return redirect('user/orderdetail/'.$order_id);
        }

        if ($status_current == 5) {

            $status_id = 5;
            $status_text = 'ยกเลิกรายการสั่งซื้อ';
            $orderStatusHistory = new OrderStatusHistory();
            $orderStatusHistory->status_id = $status_id;
            $orderStatusHistory->status_text = $status_text;
            $orderStatusHistory->note = $note;
            $orderStatusHistory->order_id = $order_id;
            $orderStatusHistory->save();

            $order['order_status'] = $status_id;
            Order::find($order_id)->update($order);

            return redirect('user/orderdetail/'.$order_id);
        }
    }

}