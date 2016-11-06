<?php

namespace App\Http\Controllers\backend;

use File;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SlideImage;

class SlideImageController extends Controller
{
    private $slideType = ['AS' => 'Activity Slide', 'B' => 'Banner Slide'];
    private $rules = [
       'slideimage_type' => 'required',
       'slideimage_name' => 'required',
       'slideimage_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:3048',
       'slideimage_urllink' => 'url',
       'sequence' => 'required|integer',
    ];

    private $rulesWithOutImage = [
       'slideimage_type' => 'required',
       'slideimage_name' => 'required',
       'slideimage_urllink' => 'url',
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
        $items = SlideImage::where('slideimage_name','like','%'.$search.'%')
                    ->orderBy('slideimage_type','ASC')
                    ->orderBy('sequence','ASC')
                    ->paginate(config('app.paginate'));
        return view('backend.slideimageindex',compact('items'))
            ->with('i', ($request->input('page', 1) - 1) * config('app.paginate'));
    }

    public function create()
    {
        $data = array('mode' => 'create', 'slideType' => $this->slideType);
        $item = new SlideImage();
        $item->sequence = 999;
        return view('backend.slideimageedit',compact('item'))->with($data);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), $this->rules)->validate();

        $uploadImage = $this->UploadImage($request);

        SlideImage::create($request->all());

        $this->UpdateImageDatabase($uploadImage);

        return redirect()->route('slideimage.index')
                       ->with('success',trans('messages.message_create_success'));
    }

    public function edit($id)
    {
        $data = array('mode' => 'edit', 'slideType' => $this->slideType);
        $item = SlideImage::find($id);
        return view('backend.slideimageedit',compact('item'))->with($data);
    }

    public function update(Request $request, $id)
    {
        if($request->slideimage_file == "")
        {
          $this->validate($request, $this->rulesWithOutImage);
          SlideImage::find($id)->update($request->all());
        }
        else {

          $this->validate($request, $this->rules);

          $uploadImage = $this->UploadImage($request);

          SlideImage::find($id)->update($request->all());

          $this->UpdateImageDatabase($uploadImage);

          $this->RemoveFolderImage($request->slideimage_file_temp);
        }

        return redirect()->route('slideimage.index')
                        ->with('success',trans('messages.message_update_success'));
    }


    public function destroy($id)
    {
        $deleteItem = SlideImage::find($id);

        $this->RemoveFolderImage($deleteItem->slideimage_file);

        $deleteItem->delete();
        return redirect()->route('slideimage.index')
                        ->with('success',trans('messages.message_delete_success'));
    }

    private function RemoveFolderImage($rawfile)
    {
        $rawfileArr = explode("/", $rawfile);
        $indexFile = count($rawfileArr) - 1;
        $indexFolder = count($rawfileArr) - 2;
        File::delete($rawfile);
        File::deleteDirectory(config('app.upload_slideimage').$rawfileArr[$indexFolder]);
    }

    private function UploadImage(Request $request)
    {
        $fileTimeStamp = time();
        $imageTempName = $request->file('slideimage_file')->getPathname();

        $imageName = $request->slideimage_file->getClientOriginalName();
        $request->slideimage_file->move(config('app.upload_slideimage').$fileTimeStamp."/", $imageName);
        $imageName = config('app.upload_slideimage').$fileTimeStamp."/".$imageName;

        return array('imageTempName'=> $imageTempName, 'imageName' => $imageName);
    }

    private function UpdateImageDatabase($uploadImage){
        SlideImage::where('slideimage_file', $uploadImage["imageTempName"])
        ->update(['slideimage_file' => $uploadImage["imageName"]]);
    }
}
