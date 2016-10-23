<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Media;

class MediaController extends Controller
{
    private $rules = [
       'media_name_th' => 'required',
       'media_name_en' => 'required',
       'media_urllink' => 'required|url',
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
        $items = Media::where('media_name_th','like','%'.$search.'%')
                    ->orwhere('media_name_en','like','%'.$search.'%')
                    ->orderBy('sequence','ASC')
                    ->paginate(config('app.paginate'));
        return view('admin.mediaindex',compact('items'))
            ->with('i', ($request->input('page', 1) - 1) * config('app.paginate'));
    }

    public function create()
    {
        $data = array('mode' => 'create');
        $item = new Media();
        $item->sequence = 999;
        return view('admin.mediaedit',compact('item'))->with($data);
    }

    public function store(Request $request)
    {
        //$this->validate($request, $this->rules, $this->messages);
        Validator::make($request->all(), $this->rules)->validate();
        Media::create($request->all());
        return redirect()->route('media.index')
                       ->with('success',trans('messages.message_create_success'));
    }

    public function edit($id)
    {
        $data = array('mode' => 'edit');
        $item = Media::find($id);
        return view('admin.mediaedit',compact('item'))->with($data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules);

        Media::find($id)->update($request->all());
        return redirect()->route('media.index')
                        ->with('success',trans('messages.message_update_success'));
    }


    public function destroy($id)
    {
        Media::find($id)->delete();
        return redirect()->route('media.index')
                        ->with('success',trans('messages.message_delete_success'));
    }
}
