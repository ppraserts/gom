<?php

namespace App\Http\Controllers\backend;

use File;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DownloadDocument;

class DownloadDocumentController extends Controller
{
    private $rules = [
       'downloaddocument_title_th' => 'required',
       'downloaddocument_title_en' => 'required',
       'downloaddocument_file' => 'required|max:8048',
       'sequence' => 'required|integer',
    ];

    private $rulesWithOutDocument = [
       'downloaddocument_title_th' => 'required',
       'downloaddocument_title_en' => 'required',
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
        $items = DownloadDocument::where('downloaddocument_title_th','like','%'.$search.'%')
                    ->orWhere('downloaddocument_title_en','like','%'.$search.'%')
                    ->orderBy('sequence','ASC')
                    ->paginate(config('app.paginate'));
        return view('backend.downloaddocumentindex',compact('items'))
            ->with('i', ($request->input('page', 1) - 1) * config('app.paginate'));
    }

    public function create()
    {
        $data = array('mode' => 'create');
        $item = new DownloadDocument();
        $item->sequence = 999;
        return view('admin.downloaddocumentedit',compact('item'))->with($data);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), $this->rules)->validate();

        $uploadDocument = $this->uploadDocument($request);

        DownloadDocument::create($request->all());

        $this->UpdateDocumentDatabase($uploadDocument);

        return redirect()->route('downloaddocument.index')
                       ->with('success',trans('messages.message_create_success'));
    }

    public function edit($id)
    {
        $data = array('mode' => 'edit');
        $item = DownloadDocument::find($id);
        return view('backend.downloaddocumentedit',compact('item'))->with($data);
    }

    public function update(Request $request, $id)
    {
        if($request->downloaddocument_file == "")
        {
          $this->validate($request, $this->rulesWithOutDocument);

          DownloadDocument::find($id)->update($request->all());
        }
        else {
          $this->validate($request, $this->rules);
          $uploadDocument = $this->uploadDocument($request);

          DownloadDocument::find($id)->update($request->all());

          $this->UpdateDocumentDatabase($uploadDocument);
          $this->RemoveFolderDocument($request->downloaddocument_file_temp);
        }
        return redirect()->route('downloaddocument.index')
                        ->with('success',trans('messages.message_update_success'));
    }


    public function destroy($id)
    {
        $deleteItem = DownloadDocument::find($id);

        $this->RemoveFolderDocument($deleteItem->downloaddocument_file);

        $deleteItem->delete();

        return redirect()->route('downloaddocument.index')
                        ->with('success',trans('messages.message_delete_success'));
    }

    private function RemoveFolderDocument($rawfile)
    {
        $rawfileArr = explode("/", $rawfile);
        $indexFile = count($rawfileArr) - 1;
        $indexFolder = count($rawfileArr) - 2;
        File::delete($rawfile);
        File::deleteDirectory(config('app.upload_document').$rawfileArr[$indexFolder]);
    }

    private function uploadDocument(Request $request)
    {
        $fileTimeStamp = time();
        $documentTempName = $request->file('downloaddocument_file')->getPathname();

        $documentName = $request->downloaddocument_file->getClientOriginalName();
        $request->downloaddocument_file->move(config('app.upload_document').$fileTimeStamp."/", $documentName);
        $documentName = config('app.upload_document').$fileTimeStamp."/".$documentName;

        return array('documentTempName'=> $documentTempName, 'documentName' => $documentName);
    }

    private function UpdateDocumentDatabase($uploadDocument){
        DownloadDocument::where('downloaddocument_file', $uploadDocument["documentTempName"])
        ->update(['downloaddocument_file' => $uploadDocument["documentName"]]);
    }
}
