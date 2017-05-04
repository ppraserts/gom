<?php
/**
 * Created by PhpStorm.
 * User: layer
 * Date: 26/3/2560
 * Time: 13:47
 */

namespace App\Http\Controllers\frontend;

use App\OrderItem;
use Validator, Response;
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

        $items = Product::with(['productCategory', 'productOrderItem','productRequest'])->Where('user_id', $user->id)->Where(function ($query) {
            $search = \Request::get('search');
            $query->where('product_name_th', 'like', '%' . $search . '%')
                ->orWhere('product_name_en', 'like', '%' . $search . '%');
        })
            ->orderBy('sequence', 'ASC')
            ->paginate(config('app.paginate'));


        $data = array('user_id' => $user->id,
            'i' => ($request->input('page', 1) - 1) * config('app.paginate'));
        /*$json = array(
            'items' => $items,
            'data' => $data
        );
        return response($json, 200);*/
        return view('frontend.productindex', compact('items'))
            ->with($data);
    }

    public function create()
    {
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
        return view('frontend.productedit', compact('item'))->with($data);
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, $this->rules);
        Product::find($id)->update($request->all());
        return redirect()->route('userproduct.index')
            ->with('success', trans('messages.message_update_success'));
    }


    public function destroy($id)
    {
        if (OrderItem::where('product_id', $id)->get()->count() > 0) {
            return redirect()->route('userproduct.index')->withErrors(Lang::get('messages.cannot_delete_product_with_order'));
        }
        Product::find($id)->delete();
        return redirect()->route('userproduct.index')
            ->with('success', trans('messages.message_delete_success'));
    }


    public function all(Request $request)
    {

        $user = auth()->guard('user')->user();

        $items = Product::with(['productCategory', 'productOrderItem'])->Where(function ($query) {
            $search = \Request::get('search');
            $query->where('product_name_th', 'like', '%' . $search . '%')
                ->orWhere('product_name_en', 'like', '%' . $search . '%');
        })
            ->orderBy('sequence', 'ASC')
            ->paginate(config('app.paginate'));


        $data = array('user_id' => $user->id,
            'i' => ($request->input('page', 1) - 1) * config('app.paginate'));
//        return response($items, 200);
        return view('frontend.productall', compact('items'))
            ->with($data);
    }
}