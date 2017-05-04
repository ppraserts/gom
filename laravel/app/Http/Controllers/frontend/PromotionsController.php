<?php

namespace App\Http\Controllers\frontend;

use App\Helpers\DateFuncs;
use App\Http\Controllers\Controller;
use App\Shop;
use Validator, Response;
use Illuminate\Http\Request;
use App\Promotions;
use File;
use Image;

class PromotionsController extends Controller
{

    private $rules = [
        'promotion_title' => 'required',
        'promotion_description' => 'required',
        'start_date' => 'required',
        'image_file' => 'required',
        'end_date' => 'required|after:start_date',
        'sequence' => 'required|integer',
    ];

    private $rulesUpdate = [
        'promotion_title' => 'required',
        'promotion_description' => 'required',
        'start_date' => 'required',
        'end_date' => 'required|after:start_date',
        'sequence' => 'required|integer',
    ];

    /*private $ruleDate = [
        'start_date' => 'required',
        'end_date' => 'required|after:start_date',
    ];*/

    /**
     * PromotionsController constructor.
     */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->guard('user')->user();
        $shop = Shop::where('user_id', $user->id)->first();

        $items = array();
        if ($shop!=null){
            $items = Promotions::where('shop_id', $shop->id)->Where(function ($query) {
                $search = \Request::get('search');
                $query->where('promotion_title', 'like', '%' . $search . '%')
                    ->orWhere('promotion_description', 'like', '%' . $search . '%');
            })
                ->orderBy('sequence', 'ASC')
                ->paginate(config('app.paginate'));
            $data = array('i' => ($request->input('page', 1) - 1) * config('app.paginate'),
            'setting_shop' => false);
            return view('frontend.promotionindex', compact('items','shop'))
                ->with($data);
        }
        else{
            $data = array('setting_shop' => true);
            return view('frontend.promotionindex', compact('items'))->with($data);;
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->guard('user')->user();
        $shop = Shop::where('user_id', $user->id)->first();
        $data = array('mode' => 'create',
            'user_id' => $user->id,
            'shop_id' => $shop->id
        );
        $item = new Promotions();
        $item->sequence = 999;
        return view('frontend.promotionedit', compact('item'))->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request['start_date'] = DateFuncs::convertYear($request['start_date']);
        $request['end_date'] = DateFuncs::convertYear($request['end_date']);

        $validator = $this->getValidationFactory()->make($request->all(), $this->rules, [], []);
        if ($validator->fails()) {
            $request['start_date'] = DateFuncs::thai_date($request['start_date']);
            $request['end_date'] = DateFuncs::thai_date($request['end_date']);
            $this->throwValidationException($request, $validator);
        }

        $promotion = $request->all();

        if ($image_file = $request->file('image_file')) {
            $uploadImage = $this->UploadImage($request, 'image_file');
            $promotion['image_file'] = $uploadImage["image_path_filename"];
        }

        Promotions::create($promotion);
        return redirect()->route('promotion.index')
            ->with('success', trans('messages.message_create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = auth()->guard('user')->user();
        $shop = Shop::where('user_id', $user->id)->first();
        $data = array('mode' => 'edit',
            'user_id' => $user->id,
            'shop_id' => $shop->id
        );
        $item = Promotions::find($id);
        return view('frontend.promotionedit', compact('item','shop'))->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request['start_date'] = DateFuncs::convertYear($request['start_date']);
        $request['end_date'] = DateFuncs::convertYear($request['end_date']);

        $validator = $this->getValidationFactory()->make($request->all(), $this->rulesUpdate, [], []);
        if ($validator->fails()) {
            $request['start_date'] = DateFuncs::thai_date($request['start_date']);
            $request['end_date'] = DateFuncs::thai_date($request['end_date']);
            $this->throwValidationException($request, $validator);
        }

        $promotion = $request->all();

        if ($request->file('image_file')!=null && $image_file = $request->file('image_file')) {
            $this->RemoveFolderImage($promotion['image_file']);
            $uploadImage = $this->UploadImage($request, 'image_file');
            $promotion['image_file'] = $uploadImage["image_path_filename"];
        }

        Promotions::find($id)->update($promotion);
        return redirect()->route('promotion.index')
            ->with('success', trans('messages.message_update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteItem = Promotions::find($id);

        $this->RemoveFolderImage($deleteItem->image_file);

        $deleteItem->delete();
        return redirect()->route('promotion.index')
            ->with('success', trans('messages.message_delete_success'));
    }

    /*public function uploadImage($request, $filename)
    {
        sleep(1);
        $image_path = $request->file($filename)->getPathname();
        $image_filename = $request->{$filename}->getClientOriginalName();
        $image_directory = config('app.upload_promotion') . time();
        $image_path_filename = $image_directory . "/" . $image_filename;
        File::makeDirectory($image_directory, 0777, true, true);

        $img = Image::make($image_path);
        $img->save($image_path_filename);
        $img->destroy();

        return array('image_path_filename' => $image_path_filename);
    }*/

    private function uploadImage(Request $request, $imagecolumnname)
    {
        sleep(1);
        $fileTimeStamp = time();
        $imageTempName = $request->file($imagecolumnname)->getPathname();

        $imageName = $request->{$imagecolumnname}->getClientOriginalName();

        //$imageName_temp = iconv('UTF-8', 'tis620',$imageName);
        $imageName_temp = $imageName;

        $request->{$imagecolumnname}->move(config('app.upload_promotion') . $fileTimeStamp . "/", $imageName_temp);
        $imageName = config('app.upload_promotion') . $fileTimeStamp . "/" . $imageName;

        return array('imageTempName' => $imageTempName, 'image_path_filename' => $imageName);
    }

    private function RemoveFolderImage($rawfile)
    {
        sleep(1);
        if ($rawfile != "") {
            $rawfileArr = explode("/", $rawfile);
            $indexFile = count($rawfileArr) - 1;
            $indexFolder = count($rawfileArr) - 2;

            if (File::exists($rawfile) && $indexFolder >= 0) {
                File::delete($rawfile);
                File::deleteDirectory(config('app.upload_promotion') . $rawfileArr[$indexFolder]);
            }
        }
    }
}