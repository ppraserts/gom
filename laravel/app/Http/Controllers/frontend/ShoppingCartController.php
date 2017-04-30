<?php

namespace App\Http\Controllers\frontend;

use App\ProductRequest;
use App\Order;
use App\OrderItem;
use App\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


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

        return view('frontend.shoppingcart', compact('shopping_carts'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    public function checkoutEachShop($user_id, $total)
    {
        if ($user_id != null && $total != null) {
            $carts_in_session = session('carts');
            if (is_array($carts_in_session)) {
                $order = new Order();
                $order->user_id = trim($user_id);
                $order->total_amount = floatval($total);
                $order->order_status = 1;
                $order->order_type = "retail";
                $order->order_date = date('Y-m-d H:i:s');
                $order->save();

                $arr_sum_product_qty = $this->sumQuantitiesWithSameProduct($carts_in_session);

                // Save Order Items
                $arr_order_items = array();
                foreach ($arr_sum_product_qty as $key => $item) {
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
                //Delete shop cart
                $this->deleteCartItemInSessionByUserId($user_id);
            }
        }
        return redirect()->route('shoppingcart.index');
    }

    private function saveOrderItem($arr_order_item)
    {
        if ($arr_order_item != null) {

            $order_item = new OrderItem();
            $order_item->unit_price = $arr_order_item['unit_price'];
            $order_item->product_request_id = $arr_order_item['id'];
            $order_item->quantity = $arr_order_item['qty'];
            $order_item->total = $arr_order_item['total'];
        }
    }


    public function saveAllOrders()
    {

    }

    public function checkout(Request $request)
    {
        $response = array("status" => "success");

        $user = auth()->guard('user')->user();

        $order = new Order();
        $order->user_id = $user->id;
        $order->total_amount = $request->input('total_amount');
        $order->order_status = 1;
        $order->order_type = "retail";
        $order->order_date = date('Y-m-d H:i:s');
        $order->save();

        $order_items = array();
        $cart_items = $request->input('cart_items');
        if ($cart_items != null && $cart_items != '') {
            foreach ($cart_items as $item) {
                $order_item = new OrderItem();
                $order_item->unit_price = $item['unit_price'];
                $order_item->product_request_id = $item['id'];
                $order_item->quantity = $item['quantity'];
                $order_item->total = $item['total'];
                array_push($order_items, $order_item);
            }

            if ($order->orderItems()->saveMany($order_items)) {
                $response['status'] = "success";
            }
        }

        //clear session
        $this->clearCart($request);

        return response()->json($response);
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

            session(['carts' => $carts_in_session]); // Save to session

            $response = array("status" => "success", "product_request" => $product_request);
        }

        return response()->json($response);
    }

    public function clearCart($request)
    {
        $request->session()->forget('carts');
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

    public function sumQuantitiesWithSameProduct($carts_in_session)
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
                $value['shop'] = Shop::find($value['user_id']);
                $arr_more_data[$key] = $value;
            }
        }
        return $arr_more_data;
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
                session(['carts' => $carts_in_session]); // Save to session
            }
        }
        return redirect()->route('shoppingcart.index');
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
                session(['carts' => $carts_in_session]); // Save to session
            }
        }
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
                    session(['carts' => $carts_in_session]); // Save to session
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
                        session(['carts' => $arr_new_cart_item]); // Save to session
                    }
                }
            }
        }
        return redirect()->route('shoppingcart.index');
    }


}
