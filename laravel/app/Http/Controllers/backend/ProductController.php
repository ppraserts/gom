<?php

namespace App\Http\Controllers\backend;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

class ProductController extends Controller
{
    private $rules = [
       'product_name_th' => 'required',
       'product_name_en' => 'required',
       'productcategory_id' => 'required',
       'sequence' => 'required|integer',
    ];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index(Request $request)
    {
        $productcategory = \Request::get('productcategory');
        $items = Product::Where('productcategory_id', '=', $productcategory)
                    ->Where(function ($query) {
                       $search = \Request::get('search');
                       $query->where('product_name_th','like','%'.$search.'%')
                             ->orWhere('product_name_en','like','%'.$search.'%');
                    })
                    ->orderBy('sequence','ASC')
                    ->paginate(config('app.paginate'));
        return view('backend.productindex',compact('items'))
            ->with('i', ($request->input('page', 1) - 1) * config('app.paginate'));
    }

    public function create()
    {
        $data = array('mode' => 'create');
        $item = new Product();
        $item->sequence = 999;
        return view('backend.productedit',compact('item'))->with($data);
    }

    public function store(Request $request)
    {
        //$this->validate($request, $this->rules, $this->messages);
        $productcategory = $_REQUEST["productcategory_id"];
        Validator::make($request->all(), $this->rules)->validate();
        Product::create($request->all());
        return redirect()->route('product.index',['productcategory'=>$productcategory])
                       ->with('success',trans('messages.message_create_success'));
    }

    public function edit($id)
    {
        $data = array('mode' => 'edit');
        $item = Product::find($id);
        return view('backend.productedit',compact('item'))->with($data);
    }

    public function update(Request $request, $id)
    {
        $productcategory = $_REQUEST["productcategory_id"];
        $this->validate($request, $this->rules);

        Product::find($id)->update($request->all());
        return redirect()->route('product.index',['productcategory'=>$productcategory])
                        ->with('success',trans('messages.message_update_success'));
    }


    public function destroy($id)
    {
        $productcategory = $_REQUEST["productcategory"];
        Product::find($id)->delete();
        return redirect()->route('product.index',['productcategory'=>$productcategory])
                        ->with('success',trans('messages.message_delete_success'));
    }
}
