<?php

namespace App\Http\Controllers\frontend;

use App\Quotation;
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

    public function store($id)
    {
        $user = auth()->guard('user')->user();
        $quotation = new Quotation();
        $quotation->user_id = $user->id;
        $quotation->product_request_id = $id;
        $quotation->is_reply = 0;
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
            ->select('users.users_firstname_th','users.users_lastname_th','users.id as seller_id','users.users_mobilephone','users.users_phone','product_requests.*','product_requests.users_id as buyer_id','product_requests.id as product_request_id','quotation.*','products.product_name_th')
            ->where('quotation.id', $id)->first();
        /*echo json_encode($quotation);
        exit();*/
        return view('frontend.quotationview', compact('quotation','user'));
    }

    public function destroy($id)
    {
        $deleteItem = Quotation::find($id);

        $deleteItem->delete();
        return redirect()->route('quotation.index')
            ->with('success', trans('messages.message_delete_success'));
    }
}