<?php

namespace App\Http\Controllers\backend;

use File;
use DB;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Market;

class MarketController extends Controller
{
    private $rules = [
       'market_title_th' => 'required',
       'market_title_en' => 'required',
       'marketimage_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:3048',
       'sequence' => 'required|integer',
    ];

     private $rulesWithOutImage = [
       'market_title_th' => 'required',
       'market_title_en' => 'required',
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
        $items = Market::where('market_title_th','like','%'.$search.'%')
                    ->orWhere('market_title_en','like','%'.$search.'%')
                    ->orWhere('market_description_en','like','%'.$search.'%')
                    ->orWhere('market_description_th','like','%'.$search.'%')
                    ->orderBy('sequence','ASC')
                    ->paginate(config('app.paginate'));
        return view('backend.marketindex',compact('items'))
            ->with('i', ($request->input('page', 1) - 1) * config('app.paginate'));
    }

    public function edit($id)
    {
        $data = array('mode' => 'edit');
        $item = Market::find($id);
        return view('backend.marketedit',compact('item'))->with($data);
    }

    public function update(Request $request, $id)
    {
          if($request->marketimage_file == "")
        {
          $this->validate($request, $this->rulesWithOutImage);
          Market::find($id)->update($request->all());
        }
        else {

          $this->validate($request, $this->rules);

          $uploadImage = $this->UploadImage($request);

          Market::find($id)->update($request->all());

          $this->UpdateImageDatabase($uploadImage);

          $this->RemoveFolderImage($request->marketimage_file_temp);
        }

        return redirect()->route('market.index')
                       ->with('success',trans('messages.message_update_success'));
    }

     private function RemoveFolderImage($rawfile)
    {
        $rawfileArr = explode("/", $rawfile);
        $indexFile = count($rawfileArr) - 1;
        $indexFolder = count($rawfileArr) - 2;
        File::delete($rawfile);
        File::deleteDirectory(config('app.upload_marketimage').$rawfileArr[$indexFolder]);
    }

    private function UploadImage(Request $request)
    {
        $fileTimeStamp = time();
        $imageTempName = $request->file('marketimage_file')->getPathname();

        $imageName = $request->marketimage_file->getClientOriginalName();
        //$imageName_temp = iconv('UTF-8', 'tis620',$imageName);
		$imageName_temp = $imageName;

        $request->marketimage_file->move(config('app.upload_marketimage').$fileTimeStamp."/", $imageName_temp);
        $imageName = config('app.upload_marketimage').$fileTimeStamp."/".$imageName;

        return array('imageTempName'=> $imageTempName, 'imageName' => $imageName);
    }

    private function UpdateImageDatabase($uploadImage){
        Market::where('marketimage_file', $uploadImage["imageTempName"])
        ->update(['marketimage_file' => $uploadImage["imageName"]]);
    }
}
