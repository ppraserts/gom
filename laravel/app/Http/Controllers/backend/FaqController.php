<?php

namespace App\Http\Controllers\backend;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Faq;

class FaqController extends Controller
{
    private $rules = [
       'faq_question_th' => 'required',
       'faq_answer_th' => 'required',
       'faq_question_en' => 'required',
       'faq_answer_en' => 'required',
       'faqcategory_id' => 'required',
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
        $faqcategory = \Request::get('faqcategory');
        $items = Faq::Where('faqcategory_id', '=', $faqcategory)
                    ->Where(function ($query) {
                       $search = \Request::get('search');
                       $query->where('faq_question_th','like','%'.$search.'%')
                             ->orWhere('faq_question_en','like','%'.$search.'%');
                    })
                    ->orderBy('sequence','ASC')
                    ->paginate(config('app.paginate'));
        return view('backend.faqindex',compact('items'))
            ->with('i', ($request->input('page', 1) - 1) * config('app.paginate'));
    }

    public function create()
    {
        $data = array('mode' => 'create');
        $item = new Faq();
        $item->sequence = 999;
        return view('backend.faqedit',compact('item'))->with($data);
    }

    public function store(Request $request)
    {
        //$this->validate($request, $this->rules, $this->messages);
        $faqcategory = $_REQUEST["faqcategory_id"];
        Validator::make($request->all(), $this->rules)->validate();
        Faq::create($request->all());
        return redirect()->route('faq.index',['faqcategory'=>$faqcategory])
                       ->with('success',trans('messages.message_create_success'));
    }

    public function edit($id)
    {
        $data = array('mode' => 'edit');
        $item = Faq::find($id);
        return view('backend.faqedit',compact('item'))->with($data);
    }

    public function update(Request $request, $id)
    {
        $faqcategory = $_REQUEST["faqcategory_id"];
        $this->validate($request, $this->rules);

        Faq::find($id)->update($request->all());
        return redirect()->route('faq.index',['faqcategory'=>$faqcategory])
                        ->with('success',trans('messages.message_update_success'));
    }


    public function destroy($id)
    {
        $faqcategory = $_REQUEST["faqcategory"];
        Faq::find($id)->delete();
        return redirect()->route('faq.index',['faqcategory'=>$faqcategory])
                        ->with('success',trans('messages.message_delete_success'));
    }
}
