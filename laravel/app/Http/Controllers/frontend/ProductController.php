<?php
/**
 * Created by PhpStorm.
 * User: layer
 * Date: 26/3/2560
 * Time: 13:47
 */

namespace App\Http\Controllers\frontend;

use App\Order;
use App\OrderItem;
use Validator,Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use Lang;

class ProductController extends Controller
{
    private $rules = [
        'productcategory_id' => 'required',
        'product_name_th' => 'required',
        'product_name_en' => 'required',
        'sequence' => 'required|integer',
    ];

    public function index(Request $request)
    {
        $user = auth()->guard('user')->user();
        $items = Product::Where('user_id', $user->id)->where('inactive', 0)->get();
        return view('frontend.productindex',compact('items'))
            ->with('i', ($request->input('page', 1) - 1) * config('app.paginate'));
    }

    public function create(){
        $user = auth()->guard('user')->user();
        $data = array('mode' => 'create',
            'user_id' => $user->id
            );
        $item = new Product();
        $item->sequence = 999;
        return view('frontend.productedit', compact('item'))->with($data);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), $this->rules)->validate();

        /** เช็คชื่อสินค้าว่ามีอยู่แล้วหรือไม่ */
        if (Product::where('product_name_th', '=', $request->product_name_th)->where('inactive', 1)->update(['inactive' => 0,'product_name_en' => $request->product_name_en,'productcategory_id' => $request->productcategory_id])) {
            return redirect()->route('userproduct.index')
                ->with('success', trans('messages.message_create_success'));
        }
        if (Product::where('product_name_th', '=', $request->product_name_th)->get()->count() > 0) {
            return redirect()->route('userproduct.index')->withErrors(sprintf(Lang::get('messages.product_exist'), $request->product_name_th));
        }
        Product::create($request->all());
        return redirect()->route('userproduct.index')
            ->with('success', trans('messages.message_create_success'));
    }

    public function edit($id)
    {
        $user = auth()->guard('user')->user();
        $data = array('mode' => 'edit',
            'user_id' => $user->id
        );
        $item = Product::find($id);
        return view('frontend.productedit',compact('item'))->with($data);
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, $this->rules);
        Product::find($id)->update($request->all());
        return redirect()->route('userproduct.index')
            ->with('success',trans('messages.message_update_success'));
    }


    public function destroy($id)
    {
        if (OrderItem::where('product_id', $id)->get()->count() > 0){
            return redirect()->route('userproduct.index')->withErrors(Lang::get('messages.cannot_delete_product_with_order'));
        }
        Product::find($id)->update(['inactive' => 1]);
        return redirect()->route('userproduct.index')
            ->with('success',trans('messages.message_delete_success'));
    }
}