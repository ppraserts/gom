<?php

namespace App\Http\Controllers\backend;

use File;
use DB;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\News;

class NewsController extends Controller
{
    private $rules = [
       'news_tags' => 'required',
       'news_title_th' => 'required',
       'news_description_th' => 'required',
       'news_title_en' => 'required',
       'news_description_en' => 'required',
       'news_created_at' => 'required',
       'news_place' => 'required',
       'news_sponsor' => 'required',
       'news_document_file' => 'max:3048',
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
        $items = News::where('news_title_th','like','%'.$search.'%')
                    ->orWhere('news_title_en','like','%'.$search.'%')
                    ->orWhere('news_description_th','like','%'.$search.'%')
                    ->orWhere('news_description_en','like','%'.$search.'%')
                    ->orWhere('news_created_at','like','%'.$search.'%')
                    ->orWhere('news_place','like','%'.$search.'%')
                    ->orWhere('news_tags','like','%'.$search.'%')
                    ->orWhere('news_sponsor','like','%'.$search.'%')
                    ->orderBy('sequence','ASC')
                    ->paginate(config('app.paginate'));
        return view('backend.newsindex',compact('items'))
            ->with('i', ($request->input('page', 1) - 1) * config('app.paginate'));
    }

    public function create()
    {
        $data = array('mode' => 'create');
        $item = new News();
        $item->sequence = 999;
        return view('backend.newsedit',compact('item'))->with($data);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), $this->rules)->validate();
        if($request->news_document_file == "")
        {
            News::create($request->all());
        }
        else {

               $uploadImage = $this->UploadImage($request);

                News::create($request->all());

                $this->UpdateImageDatabase($uploadImage);

        }
        return redirect()->route('news.index')
                       ->with('success',trans('messages.message_create_success'));
    }

    public function edit($id)
    {
        $data = array('mode' => 'edit');
        $item = News::find($id);
        return view('backend.newsedit',compact('item'))->with($data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules);
        if($request->news_document_file == "")
        {
            News::find($id)->update($request->all());
         }
        else {

              $uploadImage = $this->UploadImage($request);

              News::find($id)->update($request->all());

              $this->UpdateImageDatabase($uploadImage);

              $this->RemoveFolderImage($request->news_document_file_temp);

        }
        return redirect()->route('news.index')
                        ->with('success',trans('messages.message_update_success'));
    }


    public function destroy($id)
    {
            $news = News::find($id);
            $news->delete();
            $this->RemoveFolderImage($news->news_document_file);
            return redirect()->route('news.index')
                            ->with('success',trans('messages.message_delete_success'));
    }

    private function RemoveFolderImage($rawfile)
    {
        $rawfileArr = explode("/", $rawfile);
        $indexFile = count($rawfileArr) - 1;
        $indexFolder = count($rawfileArr) - 2;
        File::delete($rawfile);
        File::deleteDirectory(config('app.upload_news').$rawfileArr[$indexFolder]);
    }

    private function UploadImage(Request $request)
    {
        $fileTimeStamp = time();
        $imageTempName = $request->file('news_document_file')->getPathname();

        $imageName = $request->news_document_file->getClientOriginalName();
        $request->news_document_file->move(config('app.upload_news').$fileTimeStamp."/", $imageName);
        $imageName = config('app.upload_news').$fileTimeStamp."/".$imageName;

        return array('imageTempName'=> $imageTempName, 'imageName' => $imageName);
    }

    private function UpdateImageDatabase($uploadImage){
        News::where('news_document_file', $uploadImage["imageTempName"])
        ->update(['news_document_file' => $uploadImage["imageName"]]);
    }
}
