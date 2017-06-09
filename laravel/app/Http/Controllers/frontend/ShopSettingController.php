<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Shop;
use File;
use Image;

class ShopSettingController extends Controller
{

    private function rules($skipCheckUnique)
    {
        if ($skipCheckUnique) {
            return ['shop_title' => 'required',
                'shop_name' => 'required|regex:/^[A-Za-z][A-Za-z0-9]*$/'];
        } else {
            return ['shop_title' => 'required',
                'shop_name' => 'required|regex:/^[A-Za-z][A-Za-z0-9]*$/|unique:shops,shop_name'];
        }
    }

    private $shop_rules_update = [
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
        if ($shop == null){
            $shop = new Shop();
        }
        return view('frontend.shopsetting', compact('shop'));
    }

    public function store(Request $request)
    {
        $user = auth()->guard('user')->user();
        $is_exist_shop = $this->isExistShop($user->id);
        if (!$is_exist_shop) {
            $shop = new Shop();
            $shop->theme = 'theme3'; // default theme
            $this->validate($request, $this->rules(null));
        } else {
            $shop = Shop::where('user_id', $user->id)->first();
            $this->validate($request, $this->rules((strtolower($shop->shop_name))===(strtolower($request->shop_name))));
        }

        $shop->user_id = $user->id;
        $shop->shop_name = $request->input('shop_name');
        $shop->shop_title = $request->input('shop_title');
        $shop->shop_subtitle = $request->input('shop_subtitle');
        $shop->shop_description = $request->input('shop_description');
        $shop->text_color = $request->input('text_color');

        if ($request->input('image_file_1_type') == 0){
            $this->RemoveFolderImage($shop->image_file_1);
            $shop->image_file_1 = "";
        }else if ($image_file_1 = $request->file('image_file_1')) {
            $this->RemoveFolderImage($shop->image_file_1);
            $uploadImage1 = $this->UploadImage($request, 'image_file_1');
            $shop->image_file_1 = $uploadImage1["image_path_filename"];
        }

        if ($request->input('image_file_2_type') == 0){
            $this->RemoveFolderImage($shop->image_file_2);
            $shop->image_file_2 = "";
        }else if ($image_file_2 = $request->file('image_file_2')) {
            $uploadImage2 = $this->UploadImage($request, 'image_file_2');
            $this->RemoveFolderImage($shop->image_file_2);
            $shop->image_file_2 = $uploadImage2["image_path_filename"];
        }

        if ($request->input('image_file_3_type') == 0){
            $this->RemoveFolderImage($shop->image_file_3);
            $shop->image_file_3 = "";
        }else if ($image_file_3 = $request->file('image_file_3')) {
            $uploadImage3 = $this->UploadImage($request, 'image_file_3');
            $this->RemoveFolderImage($shop->image_file_3);
            $shop->image_file_3 = $uploadImage3["image_path_filename"];
        }

        if (!$is_exist_shop) {
            $shop->save();
        } else {
            $shop->update();
        }

        //update shop into session
        $shop_setting = array(
            'theme' => $shop->theme,
            'shop_name' => $shop->shop_name,
        );
        session(['shop' => $shop_setting]);

        return redirect()->route('shopsetting.index')->with('success', trans('messages.message_update_success'));
    }

    public function uploadImage($request, $filename)
    {
        sleep(1);
        $image_path = $request->file($filename)->getPathname();
        $orgFilePathName = $request->{$filename}->getClientOriginalName();
        $ext = pathinfo($orgFilePathName, PATHINFO_EXTENSION);
        $image_directory = config('app.shopimage');
        $image_path_filename = $image_directory . time() .".".$ext;
//        File::makeDirectory($image_directory, 0777, true, true);

        $img = Image::make($image_path);
        $img->save($image_path_filename);
        $img->destroy();

        return array('image_path_filename' => $image_path_filename);
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
