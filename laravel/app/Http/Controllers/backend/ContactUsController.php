<?php

namespace App\Http\Controllers\backend;

use File;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ContactUs;

class ContactUsController extends Controller
{
    private $rules = [
       'contactus_address_th' => 'required',
       'contactus_address_en' => 'required',
       'contactus_latitude' => 'required|numeric',
       'contactus_longitude' => 'required|numeric',
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

    public function index()
    {
        $data = array('mode' => 'edit');
        $item = ContactUs::find(1);
        if($item == null)
          $item = new ContactUs();
        return view('backend.contactusedit',compact('item'))->with($data);
    }

    public function update(Request $request)
    {
        $this->validate($request, $this->rules);
        $item = ContactUs::find(1);
        if($item == null)
            ContactUs::create($request->all());
        else
            ContactUs::find(1)->update($request->all());

        return redirect()->route('contactus.index')
                        ->with('success',trans('messages.message_update_success'));
    }
}
