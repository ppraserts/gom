<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Order;
use App\OrderItem;
use DB;
use App\OrderStatusHistory;
use App\ProductRequest;
use Illuminate\Http\Request;
use Redirect,Session;


class ShoppingCartController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function index()
    {
        $shopping_carts = array();
        $carts_in_session = session('carts');
        if (is_array($carts_in_session)) {
            $arr_summary_quantities = $this->sumQuantitiesWithSameProduct($carts_in_session);
            $shopping_carts = $this->summarizeDataShoppingCarts($arr_summary_quantities);
        }
        //return $shopping_carts;
        return view('frontend.shoppingcart', compact('shopping_carts'));
    }

    public function show($id)
    {
    }

    public function checkout(Request $request,$user_id, $total)
    {
        $current_user = auth()->guard('user')->user();
        if ($user_id != null && $total != null) {
            $delivery_chanel =  $request->input('delivery_chanel');
            $address_delivery =  $request->input('address_delivery');
            $carts_in_session = session('carts');
            if (is_array($carts_in_session)) {
                $this->saveOrder($carts_in_session , $user_id , $current_user , $total,$delivery_chanel,$address_delivery);
            }
        }
        $this->deleteCartItemInSessionByUserId($user_id);
        if(count(session('carts')) > 0){
            return redirect()->route('shoppingcart.index')->with('success', trans('messages.message_update_success'));
        }
        Session::flash('success', trans('messages.message_buy_success'));
        return redirect('user/order');
    }

    public function checkoutAll(Request $request)
    {
        $delivery_chanel =  $request->input('delivery_chanel');
        $address_delivery =  $request->input('address_delivery');
        $i_address = 0;
        $count_address = count($address_delivery);
        $dataArr = array();
        foreach ($delivery_chanel as $var){
            //return $var;
            if($var == 'รับเอง'){
                $address_delivery_new = '';
                if($i_address == 0){

                }else{
                    $i_address--;
                }
            }else{
                $address_delivery_new = $address_delivery[$i_address];
                $i_address++;
            }
            $arr[] = array($var,$address_delivery_new);
            //array_push($dataArr,$arr);

        }
        //return $arr[1][0];
        $current_user = auth()->guard('user')->user();
        $carts_in_session = session('carts');
        if (is_array($carts_in_session)) {
            $arr_summary_quantities = $this->sumQuantitiesWithSameProduct($carts_in_session);
            $shopping_carts = $this->summarizeDataShoppingCarts($arr_summary_quantities);
            $countArr = 0;
            foreach ($shopping_carts as $key => $carts){
                $total = 0;
                foreach ($arr_summary_quantities as $key_total=>$item){
                    if($key == $item['user_id']){
                        $total+= intval($item['qty']) * floatval($item['unit_price']);
                    }
                }
                $this->saveOrder($carts , $key , $current_user , $total, $arr[$countArr][0], $arr[$countArr][1]);
                $countArr++;
            }
        }

        $this->deleteCartsInSession($request);
        //return redirect()->route('shoppingcart.index')->with('success', trans('messages.message_update_success'));
        Session::flash('success', trans('messages.message_buy_success'));
        return redirect('user/order');
    }

    public function addToCart(Request $request)
    {
        $response = array("status" => "failed", "product_request" > null);

        $request_product_request_id = $request->input('product_request_id');
        $request_user_id = $request->input('user_id');
        $request_unit_price = $request->input('unit_price');
        $product_request = ProductRequest::find($request_product_request_id);

        if ($product_request != null) {
            $carts_in_session = session('carts');
            if ($carts_in_session == null)
                $carts_in_session = array();

            $new_cart_item = array(
                "product_request_id" => $product_request->id,
                "user_id" => $request_user_id,
                "unit_price" => $request_unit_price,
                "qty" => 1);

            array_push($carts_in_session, $new_cart_item);

            $this->saveCartsToSession($carts_in_session);

            $response = array("status" => "success", "product_request" => $product_request);
        }
        return response()->json($response);
    }
    
    public function summarizeDataShoppingCarts($arr_summarize_quantities)
    {
        $arr_shop_carts = array();
        if ($arr_summarize_quantities != null) {
            foreach ($arr_summarize_quantities as $key => $item) {
                $arr_shop_carts[$item['user_id']][$key] = $item;
            }
            ksort($arr_shop_carts, SORT_NUMERIC);
        }
        return $arr_shop_carts;
    }

    public function deleteCartItem($user_id, $product_request_id)
    {
        if ($user_id != null && $product_request_id != null) {
            $carts_in_session = session('carts');
            if (is_array($carts_in_session)) {
                foreach ($carts_in_session as $key => $item) {
                    if ($item['user_id'] == trim($user_id) && $item['product_request_id'] == trim($product_request_id)) {
                        unset($carts_in_session[$key]);
                    }
                }
                $this->saveCartsToSession($carts_in_session);
            }
        }
        return redirect()->route('shoppingcart.index');
    }

    public function incrementQuantityCartItem($user_id, $product_request_id, $unit_price, $is_added)
    {
        if ($user_id != null && $product_request_id != null && $is_added != null) {
            $carts_in_session = session('carts');
            if (is_array($carts_in_session)) {
                if (boolval($is_added)) {
                    $new_cart_item = array(
                        "product_request_id" => $product_request_id,
                        "unit_price" => $unit_price,
                        "user_id" => $user_id,
                        "qty" => 1
                    );
                    array_push($carts_in_session, $new_cart_item);
                    $this->saveCartsToSession($carts_in_session);
                } else {
                    if (is_array($carts_in_session)) {
                        // Add new Items
                        $arr_new_cart_item = array();
                        $arr_need_to_delete_item = array();
                        foreach ($carts_in_session as $key => $item) {
                            if ($item['user_id'] == trim($user_id) && $item['product_request_id'] == trim($product_request_id)) {
                                array_push($arr_need_to_delete_item, $item);
                            } else {
                                array_push($arr_new_cart_item, $item);
                            }
                        }

                        unset($arr_need_to_delete_item[count($arr_need_to_delete_item) - 1]);
                        $arr_new_cart_item = array_merge($arr_new_cart_item, $arr_need_to_delete_item);
                        $this->saveCartsToSession($arr_new_cart_item);
                    }
                }
            }
        }
        return redirect()->route('shoppingcart.index');
    }

    private function sumQuantitiesWithSameProduct($carts_in_session)
    {
        $arr_summary_qty = array_reduce($carts_in_session, function ($v1, $v2) {
            isset($v1[$v2['product_request_id']]) ? $v1[$v2['product_request_id']]['qty'] += $v2['qty'] : $v1[$v2['product_request_id']] = $v2;
            return $v1;
        });

        $arr_summary_qty = $this->addMoreData($arr_summary_qty);
        return $arr_summary_qty;
    }

    private function addMoreData($arr_summary_qty)
    {
        $arr_more_data = array();
        if ($arr_summary_qty != null) {
            foreach ($arr_summary_qty as $key => $value) {
                $value['product_request'] = ProductRequest::find($value['product_request_id']);
                $arr_more_data[$key] = $value;
            }
        }
        return $arr_more_data;
    }

    private function saveOrder($arr_carts, $user_id, $current_user, $total,$delivery_chanel, $address_delivery ='')
    {
        if (is_array($arr_carts)) {
            $order = new Order();
            $order->user_id = trim($user_id);
            $order->buyer_id = $current_user->id;
            $order->total_amount = floatval($total);
            $order->order_status = 1;
            $order->order_type = "retail";
//            $order->order_type = "ขายปลีก";
            $order->order_date = date('Y-m-d H:i:s');
            $order->delivery_chanel = $delivery_chanel;
            $order->address_delivery = $address_delivery;
            $order->save();

            $arr_summary_quantities = $this->sumQuantitiesWithSameProduct($arr_carts);

            // Save Order Items
            $arr_order_items = array();
            foreach ($arr_summary_quantities as $key => $item) {
                if ($item['user_id'] == trim($user_id)) {
                    $order_item = new OrderItem();
                    $order_item->unit_price = $item['unit_price'];
                    $order_item->product_request_id = $item['product_request_id'];
                    $order_item->quantity = $item['qty'];
                    $order_item->total = intval($item['qty']) * floatval($item['unit_price']);
                    array_push($arr_order_items, $order_item);
                }
            }
            $order->orderItems()->saveMany($arr_order_items);
            $orderStatusHistory = new OrderStatusHistory();
            $orderStatusHistory->status_id = 1;
            $orderStatusHistory->status_text = 'สั่งซื้อ';
            $orderStatusHistory->order_id = $order->id;
            $orderStatusHistory->save();
        }
    }

    private function deleteCartItemInSessionByUserId($user_id)
    {
        if ($user_id != null) {
            $carts_in_session = session('carts');
            if (is_array($carts_in_session)) {
                foreach ($carts_in_session as $key => $item) {
                    if ($item['user_id'] == trim($user_id)) {
                        unset($carts_in_session[$key]);
                    }
                }
                $this->saveCartsToSession($carts_in_session);
            }
        }
    }

    private function saveCartsToSession($carts){
        session(['carts' => $carts]);
    }

    public function deleteCartsInSession($request)
    {
        $request->session()->forget('carts');
    }


}
