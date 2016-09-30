<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Faq;

class FaqController extends Controller
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
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $faqcategory = \Request::get('faqcategory');
        $items = Faq::Where('faqcategory_id', '=', $faqcategory)
                    ->Where(function ($query) {
                       $search = \Request::get('search');
                       $query->where('faq_question_th','like','%'.$search.'%')
                             ->orWhere('faq_question_en','like','%'.$search.'%');
                    })
                    ->orderBy('sequence','ASC')
                    ->paginate(config('app.paginate'));
        return view('admin.faqindex',compact('items'))
            ->with('i', ($request->input('page', 1) - 1) * config('app.paginate'));
    }

    public function create()
    {
        $data = array('mode' => 'create');
        $item = new Faq();
        $item->sequence = 999;
        return view('admin.faqedit',compact('item'))->with($data);
    }

    public function store(Request $request)
    {
        //$this->validate($request, $this->rules, $this->messages);
        Validator::make($request->all(), $this->rules)->validate();
        Faq::create($request->all());
        return redirect()->route('faq.index')
                       ->with('success',trans('messages.message_create_success'));
    }

    public function edit($id)
    {
        $data = array('mode' => 'edit');
        $item = Faq::find($id);
        return view('admin.faqedit',compact('item'))->with($data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules);

        Faq::find($id)->update($request->all());
        return redirect()->route('faq.index')
                        ->with('success',trans('messages.message_update_success'));
    }


    public function destroy($id)
    {
        Faq::find($id)->delete();
        return redirect()->route('faq.index')
                        ->with('success',trans('messages.message_delete_success'));
    }
}
