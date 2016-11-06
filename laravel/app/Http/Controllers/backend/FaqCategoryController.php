<?php

namespace App\Http\Controllers\backend;

use DB;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FaqCategory;

class FaqCategoryController extends Controller
{
    private $rules = [
       'faqcategory_title_th' => 'required',
       'faqcategory_title_en' => 'required',
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
        $search = \Request::get('search');
        $items = FaqCategory::where('faqcategory_title_th','like','%'.$search.'%')
                    ->orWhere('faqcategory_title_en','like','%'.$search.'%')
                    ->orWhere('faqcategory_description_en','like','%'.$search.'%')
                    ->orWhere('faqcategory_description_th','like','%'.$search.'%')
                    ->orderBy('sequence','ASC')
                    ->paginate(config('app.paginate'));
        return view('backend.faqcategoryindex',compact('items'))
            ->with('i', ($request->input('page', 1) - 1) * config('app.paginate'));
    }

    public function create()
    {
        $data = array('mode' => 'create');
        $item = new FaqCategory();
        $item->sequence = 999;
        return view('backend.faqcategoryedit',compact('item'))->with($data);
    }

    public function store(Request $request)
    {
        //$this->validate($request, $this->rules, $this->messages);
        Validator::make($request->all(), $this->rules)->validate();
        FaqCategory::create($request->all());
        return redirect()->route('faqcategory.index')
                       ->with('success',trans('messages.message_create_success'));
    }

    public function edit($id)
    {
        $data = array('mode' => 'edit');
        $item = FaqCategory::find($id);
        return view('backend.faqcategoryedit',compact('item'))->with($data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules);

        FaqCategory::find($id)->update($request->all());
        return redirect()->route('faqcategory.index')
                        ->with('success',trans('messages.message_update_success'));
    }


    public function destroy($id)
    {
        $total = DB::select(DB::raw("select count(*) as cnt from faq where faqcategory_id = $id "));
        if($total[0]->cnt == 0){
            FaqCategory::find($id)->delete();
            return redirect()->route('faqcategory.index')
                            ->with('success',trans('messages.message_delete_success'));
        }
        else {
          return redirect()->route('faqcategory.index')
                          ->with('error',trans('messages.message_delete_inuse'));
        }
    }
}
