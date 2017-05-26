<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BadWord;
use App\Config;
use Validator;

class BadWordController extends Controller
{

    private $rules = [
        'bad_word' => 'required'
    ];

    private $rules_censor = [
        'censor_word' => 'required'
    ];


    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $items = BadWord::Where(function ($query) {
                $search = \Request::get('search');
                $query->where('bad_word','like','%'.$search.'%');
            })
            ->orderBy('bad_word','ASC')
            ->paginate(config('app.paginate'));

        $config = Config::find(1);

        return view('backend.badwordindex',compact('items','config'))
            ->with('i', ($request->input('page', 1) - 1) * config('app.paginate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array('mode' => 'create');
        $item = new BadWord();
        return view('backend.badwordedit',compact('item'))->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), $this->rules)->validate();
        BadWord::create($request->all());
        return redirect()->route('badword.index')
        ->with('success',trans('messages.message_create_success'));
    }

    public function censor(Request $request){
        Validator::make($request->all(), $this->rules_censor)->validate();
        $config = Config::find(1);
        $config->censor_word = $request['censor_word'];
        $config->save();
        return redirect()->route('badword.index')
            ->with('success',trans('messages.message_update_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BadWord  $badWord
     * @return \Illuminate\Http\Response
     */
    public function show(BadWord $badWord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BadWord  $badWord
     * @return \Illuminate\Http\Response
     */
    public function edit(BadWord $badWord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BadWord  $badWord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BadWord $badWord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BadWord  $badWord
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BadWord::find($id)->delete();
        return redirect()->route('badword.index')
            ->with('success', trans('messages.message_delete_success'));
    }
}
