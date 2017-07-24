<?php

namespace App\Http\Controllers\frontend;

use App\Quotation;
use App\Order;
use App\OrderItem;
use App\OrderStatusHistory;
use Session,Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    //
    private $rules = [
        'price' => 'min:1',
    ];

    public function __construct()
    {
        $this->middleware('user');
    }

    public function index(Request $request)
    {
        $user = auth()->guard('user')->user();
        $quotations = Quotation::join('product_requests', 'quotation.product_request_id', '=', 'product_requests.id')
            ->join('products', 'product_requests.products_id', '=', 'products.id')
            ->select('quotation.*','product_requests.product_title','products.product_name_th')
            ->where('quotation.user_id', $user->id)->Where(function ($query) {
                $search = \Request::get('search');
                $query->where('product_requests.product_title', 'like', '%' . $search . '%')
                    ->orWhere('products.product_name_th', 'like', '%' . $search . '%');
            })
            ->orderBy('quotation.id', 'DESC')
            ->paginate(config('app.paginate'));
        $data = array('i' => ($request->input('page', 1) - 1) * config('app.paginate'));

        return view('frontend.quotationindex', compact('quotations', 'data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    /*public function show($id)
    {

    }*/

    public function store($id,$quantity)
    {
        $user = auth()->guard('user')->user();
        $quotation = new Quotation();
        $quotation->user_id = $user->id;
        $quotation->product_request_id = $id;
        $quotation->is_reply = 0;
        $quotation->quantity = $quantity;
//        return $quotation;
        $quotation->save();

        return redirect()->route('quotation.index')
            ->with('success', trans('messages.message_create_success'));

    }

    public function show($id)
    {
        $user = auth()->guard('user')->user();
        $quotation = Quotation::join('product_requests', 'quotation.product_request_id', '=', 'product_requests.id')
            ->join('products', 'product_requests.products_id', '=', 'products.id')
            ->join('users','users.id','=','product_requests.users_id')
            ->join('users as buyer','buyer.id','=','quotation.user_id')
            ->select('users.users_firstname_th','users.users_lastname_th','users.id as seller_id','users.users_mobilephone','users.users_phone','buyer.users_firstname_th as buyer_firstname','buyer.users_lastname_th as buyer_lastname','product_requests.*','product_requests.*','quotation.*','products.product_name_th')
            ->where('quotation.id', $id)->first();
        return view('frontend.quotationview', compact('quotation','user'));
    }

    public function destroy($id)
    {
        $deleteItem = Quotation::find($id);

        $deleteItem->delete();
        return redirect()->route('quotation.index')
            ->with('success', trans('messages.message_delete_success'));
    }

    public function checkout(Request $request)
    {
        $current_user = auth()->guard('user')->user();
        if (!empty($request->input('user_id'))) {
            $user_id =  $request->input('user_id');
            $delivery_chanel =  $request->input('delivery_chanel');
            $address_delivery =  $request->input('address_delivery');
            $product_request_id =  $request->input('product_request_id');
            $total =  $request->input('price_total');
            $qty=  $request->input('qty');
            $unit_price=  $request->input('unit_price');
            $this->saveOrder($user_id,$product_request_id,$current_user,$qty,$total,$unit_price,$delivery_chanel,$address_delivery);
            return Response::json(array('R'=>'Y'));

        }



    }

    private function saveOrder($user_id,$product_request_id,$current_user,$qty,$total,$unit_price,$delivery_chanel,$address_delivery ='')
    {
        if (!empty($user_id)) {
            $data['user_id'] = trim($user_id);
            $data['buyer_id'] = $current_user->id;
            $data['total_amount'] = floatval($total);
            $data['order_status'] = 1;
            $data['order_type'] = "wholesale";
            $data['order_date'] = date('Y-m-d H:i:s');
            $data['delivery_chanel'] = $delivery_chanel;
            $data['address_delivery'] = $address_delivery;
            $Order_id = Order::insertGetId($data);
            // Save Order Items
            $data_ot['order_id'] = trim($Order_id);
            $data_ot['product_request_id'] = $product_request_id;
            $data_ot['unit_price'] = $unit_price;
            $data_ot['quantity'] = $qty;
            $data_ot['total'] = $total;
            OrderItem::insert($data_ot);

            $orderStatusHistory = new OrderStatusHistory();
            $orderStatusHistory->status_id = 1;
            $orderStatusHistory->status_text = 'สั่งซื้อ';
            $orderStatusHistory->order_id = $Order_id;
            $orderStatusHistory->save();
        }
    }
}