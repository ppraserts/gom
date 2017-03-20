<?php

namespace App\Http\Controllers\frontend;

use App\Iwantto;
use App\Order;
use App\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ShoppingCartController extends Controller
{

    function __construct()
    {

    }

    public function index()
    {
        $carts = array();
        $session_carts = session('carts');
        if(is_array($session_carts)){
            foreach($session_carts as $item){
                $cart = array(
                    "iwantto" => Iwantto::find($item['iwantto_id']),
                    "qty" => 1
                );
                array_push($carts , $cart);
            }
        }

        return view('frontend.shoppingcart', compact('carts'));
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
        $cart_items  = $request->input('cart_items');
        if($cart_items != null && $cart_items != ''){
            foreach ($cart_items as $item){
                $order_item = new OrderItem();
                $order_item->iwantto_id = $item['id'];
                $order_item->unit_price = $item['unit_price'];
                $order_item->product_id = $item['product_id'];
                $order_item->quantity = $item['quantity'];
                $order_item->total = $item['total'];
                array_push( $order_items , $order_item);
            }
        }

        if($order->orderItems()->saveMany($order_items)){
            $response['status'] = "success";
        }

        //clear session
        $this->clearCart($request);

        return response()->json($response);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function addToCart(Request $request)
    {
        $request_iwantto_id = $request->input('iwantto_id');
        $iwantto = Iwantto::find($request_iwantto_id);

        $response = array("status" => "failed", "iwantto" > null);

        if($iwantto != null){
            $carts_in_session = session('carts');
            if ($carts_in_session == null)
                $carts_in_session = array();

            $new_carts = array(
                "iwantto_id" => $iwantto->id,
                "qty" => 1);

            array_push($carts_in_session, $new_carts);

            session(['carts' => $carts_in_session]); // Save to session

            $response = array("status" => "success", "iwantto" => $iwantto);
        }

        return response()->json($response);
    }

    public function clearCart($resuest){
        $resuest->session()->forget('carts');
    }

}
