<?php

namespace App\Http\Controllers\frontend\shop;

use App\Iwantto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use phpDocumentor\Reflection\Types\Array_;

class ShoppingCartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // Load list of product from session

        /*        $orders = array();

                $order1 = new Order();
                $order1->id = 1;
                $order1->order_status = 2;
                $order1->total_amount = 1000;

                $order2 = new Order();
                $order2->id = 2;
                $order2->order_status = 3;
                $order2->total_amount = 555;

                array_push($orders, $order1);
                array_push($orders, $order2);
                session(['orders' => $orders]);*/


        $orders = session('orders');

        return view('frontend.shopping.shopping_cart', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addToCart(Request $request)
    {
        $request_iwantto_id = $request->input('iwantto_id');
        $iwantto = Iwantto::find($request_iwantto_id);

       // $request->session()->forget('carts');

        $carts_in_session = session('carts');

        if($carts_in_session != null && count($carts_in_session) > 0 ){
            $arr_exist_cart = array();

            for($i= 0 ; $i < count($carts_in_session) ; $i++){
               // print_r($carts_in_session[$i]);
                $key = array_keys($carts_in_session[$i][0]);

                if($request_iwantto_id == $key){
                    echo "OK";
                }
            }

        }else{
            // add new cart to session
            $carts_in_session = array();

            $new_carts = array(
                          $request_iwantto_id => array(
                                     "iwantto_id" => $iwantto->id,
                                     "item_count" => 1)
                          );

            array_push($carts_in_session, $new_carts);
        }

       // session(['carts' => $carts_in_session]); // Save to session

        $response = array(
            "status" => "success",
            "iwantto" => $iwantto
        );
        return response()->json($response);
    }
}
