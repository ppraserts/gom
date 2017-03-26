<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Shop;
use File;

class ShopSettingController extends Controller
{

    private $shop_rules = [
        'shop_title' => 'required',
        'shop_name' => 'required|regex:/^[A-Za-z][A-Za-z0-9]*$/'
    ];

    public function __construct()
    {
        $this->middleware('user');
    }

    public function index()
    {
        $user = auth()->guard('user')->user();
        $shop = Shop::where('user_id', $user->id)->first();
        return view('frontend.shopsetting', compact('shop'));
    }

    public function store(Request $request)
    {
        $user = auth()->guard('user')->user();
        $is_exist_shop = $this->isExistShop($user->id);
        if (!$is_exist_shop) {
            $shop = new Shop();
        } else {
            $shop = Shop::where('user_id', $user->id)->first();
        }

        $this->validate($request, $this->shop_rules);

        $shop->user_id = $user->id;
        $shop->shop_name = $request->input('shop_name');
        $shop->shop_title = $request->input('shop_title');
        $shop->shop_subtitle = $request->input('shop_subtitle');
        $shop->shop_description = $request->input('shop_description');

        if ($image_file_1 = $request->file('image_file_1')) {
            $this->RemoveFolderImage($shop->image_file_1);
            $uploadImage1 = $this->UploadImage($request, 'image_file_1');
            $shop->image_file_1 = $uploadImage1["imageName"];
        }

        if ($image_file_2 = $request->file('image_file_2')) {
            $uploadImage2 = $this->UploadImage($request, 'image_file_2');
            $this->RemoveFolderImage($shop->image_file_2);
            $shop->image_file_2 = $uploadImage2["imageName"];
        }

        if ($image_file_3 = $request->file('image_file_3')) {
            $uploadImage3 = $this->UploadImage($request, 'image_file_3');
            $this->RemoveFolderImage($shop->image_file_3);
            $shop->image_file_3 = $uploadImage3["imageName"];
        }

        if (!$is_exist_shop) {
            $shop->save();
        } else {
            $shop->update();
        }

        return redirect()->route('shopsetting.index')->with('success', trans('messages.message_update_success'));
    }

    public function uploadImage($request, $file_name)
    {
        sleep(1);
        $fileTimeStamp = time();
        $imageTempName = $request->file($file_name)->getPathname();

        $imageName = $request->{$file_name}->getClientOriginalName();
        $request->{$file_name}->move(config('app.upload_shopimage') . $fileTimeStamp . "/", $imageName);
        $imageName = config('app.upload_shopimage') . $fileTimeStamp . "/" . $imageName;

        return array('imageTempName' => $imageTempName, 'imageName' => $imageName);
    }

    private function RemoveFolderImage($rawfile)
    {
        sleep(1);
        if ($rawfile != "") {
            $rawfileArr = explode("/", $rawfile);
            $indexFile = count($rawfileArr) - 1;
            $indexFolder = count($rawfileArr) - 2;

            if (File::exists($rawfile)) {
                File::delete($rawfile);
                File::deleteDirectory(config('app.upload_shopimage') . $rawfileArr[$indexFolder]);
            }
        }
    }

    private function isExistShop($user_id)
    {
        $shop = Shop::where('user_id', $user_id)->first();
        if ($shop != null) {
            return true;
        }
        return false;
    }

    public function setTheme($theme_name)
    {
        $user = auth()->guard('user')->user();
        $shop = Shop::where('user_id', $user->id)->first();
        if ($shop != null && $theme_name != '') {
            $shop->theme = $theme_name;
            $shop->update();

            $shop_setting = session('shop');
            if ($shop_setting == null)
                $shop_setting = array();

            $shop_setting["theme"] = $theme_name;
            $shop_setting["shop_name"] = $shop->shop_name;
            session(['shop' => $shop_setting]); // Save to session

        }
         return redirect()->route('shopsetting.index')->with('success', trans('messages.message_update_success'));
    }

}
