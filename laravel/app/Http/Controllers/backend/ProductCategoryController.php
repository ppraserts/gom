<?php

namespace App\Http\Controllers\backend;
use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductCategory;

class ProductCategoryController extends Controller
{
    private $rules = [
       'productcategory_title_th' => 'required',
       'productcategory_title_en' => 'required',
       'sequence' => 'required|integer',
    ];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $search = \Request::get('search');
        $items = ProductCategory::where('productcategory_title_th','like','%'.$search.'%')
                    ->orWhere('productcategory_title_en','like','%'.$search.'%')
                    ->orWhere('productcategory_description_en','like','%'.$search.'%')
                    ->orWhere('productcategory_description_th','like','%'.$search.'%')
                    ->orderBy('sequence','ASC')
                    ->paginate(config('app.paginate'));
        return view('backend.productcategoryindex',compact('items'))
            ->with('i', ($request->input('page', 1) - 1) * config('app.paginate'));
    }

    public function create()
    {
        $data = array('mode' => 'create');
        $item = new ProductCategory();
        $item->sequence = 999;
        return view('backend.productcategoryedit',compact('item'))->with($data);
    }

    public function store(Request $request)
    {
        //$this->validate($request, $this->rules, $this->messages);
        Validator::make($request->all(), $this->rules)->validate();
        ProductCategory::create($request->all());
        return redirect()->route('productcategory.index')
                       ->with('success',trans('messages.message_create_success'));
    }

    public function edit($id)
    {
        $data = array('mode' => 'edit');
        $item = ProductCategory::find($id);
        return view('backend.productcategoryedit',compact('item'))->with($data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules);

        ProductCategory::find($id)->update($request->all());
        return redirect()->route('productcategory.index')
                        ->with('success',trans('messages.message_update_success'));
    }


    public function destroy($id)
    {
        ProductCategory::find($id)->delete();
        return redirect()->route('productcategory.index')
                        ->with('success',trans('messages.message_delete_success'));
    }
}
