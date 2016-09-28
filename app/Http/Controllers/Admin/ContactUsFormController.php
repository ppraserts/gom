<?php

namespace App\Http\Controllers\Admin;

use File;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ContactUsForm;

class ContactUsFormController extends Controller
{
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
        $search = \Request::get('search');
        $items = ContactUsForm::where('contactusform_name','like','%'.$search.'%')
                    ->orWhere('contactusform_surname','like','%'.$search.'%')
                    ->orWhere('contactusform_phone','like','%'.$search.'%')
                    ->orWhere('contactusform_subject','like','%'.$search.'%')
                    ->orWhere('contactusform_messagebox','like','%'.$search.'%')
                    ->orderBy('created_at','DESC')
                    ->paginate(config('app.paginate'));
        return view('admin.contactusformindex',compact('items'))
            ->with('i', ($request->input('page', 1) - 1) * config('app.paginate'));
    }

    public function destroy($id)
    {
        $deleteItem = ContactUsForm::find($id);

        if($deleteItem->contactusform_file != "")
          $this->RemoveFolderDocument($deleteItem->contactusform_file);

        $deleteItem->delete();
        return redirect()->route('contactusform.index')
                        ->with('success',trans('messages.message_delete_success'));
    }

    private function RemoveFolderDocument($rawfile)
    {
        $rawfileArr = explode("/", $rawfile);
        $indexFile = count($rawfileArr) - 1;
        $indexFolder = count($rawfileArr) - 2;
        File::delete(public_path($rawfile));
        File::deleteDirectory(public_path(config('app.upload_contactus').$rawfileArr[$indexFolder]));
    }
}
