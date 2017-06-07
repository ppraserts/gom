<?php

namespace App\Http\Controllers\frontend;

use App\Quotation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuoteController extends Controller
{

    private $rules = [
        'price' => 'min:1',
    ];

    public function __construct()
    {
        $this->middleware('user');
    }

    public function index(Request $request){
        $user = auth()->guard('user')->user();
        $quotations = Quotation::join('product_requests', 'quotation.product_request_id', '=', 'product_requests.id')
            ->join('products', 'product_requests.products_id', '=', 'products.id')
            ->join('users','users.id','=','quotation.user_id')
            ->select('users.users_firstname_th','users.users_lastname_th','users.users_mobilephone','users.users_phone','quotation.*','product_requests.product_title','products.product_name_th')
            ->where('product_requests.users_id', $user->id)->Where(function ($query) {
                $search = \Request::get('search');
                $query->where('product_requests.product_title', 'like', '%' . $search . '%')
                    ->orWhere('products.product_name_th', 'like', '%' . $search . '%');
            })
            ->orderBy('quotation.id', 'DESC')
            ->paginate(config('app.paginate'));
        $data = array('i' => ($request->input('page', 1) - 1) * config('app.paginate'));

        return view('frontend.quoteindex', compact('quotations', 'data'));
    }

    public function edit($id){

        $quotation = Quotation::join('product_requests', 'quotation.product_request_id', '=', 'product_requests.id')
            ->join('products', 'product_requests.products_id', '=', 'products.id')
            ->join('users','users.id','=','quotation.user_id')
            ->select('users.users_firstname_th','users.users_lastname_th','users.users_mobilephone','users.users_phone','product_requests.*','quotation.*','products.product_name_th')
            ->where('quotation.id', $id)->first();

        /*echo $quotation;
        exit();*/
        return view('frontend.quoteedit', compact('quotation'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules);
        $request['is_reply'] = 1;
        $quotation = $request->all();
        Quotation::find($id)->update($quotation);

        return redirect()->route('quote.index')
            ->with('success', trans('messages.message_update_success'));

    }



    public function show($id)
    {
        $user = auth()->guard('user')->user();
        $quotation = Quotation::join('product_requests', 'quotation.product_request_id', '=', 'product_requests.id')
            ->join('products', 'product_requests.products_id', '=', 'products.id')
            ->join('users','users.id','=','quotation.user_id')
            ->select('users.users_firstname_th','users.users_lastname_th','users.users_mobilephone','users.users_phone','product_requests.*','quotation.*','products.product_name_th')
            ->where('quotation.id', $id)->first();
        return view('frontend.quotationview', compact('quotation','user'));
    }
}
