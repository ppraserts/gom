<?php

namespace App\Http\Controllers\frontend;

use App\Helpers\DateFuncs;
use App\Http\Controllers\Controller;
use App\Province;
use App\UserStandard;
use DB;
use File;
use Hash;
use Image;
use Illuminate\Http\Request;
use Validator;
use App\Standard;

class UserProfileController extends Controller
{
    private $rules = [
        'users_firstname_th' => 'required|max:255',
        'users_lastname_th' => 'required|max:255',
//    'users_dateofbirth' => 'required|date_format:Y-m-d',
        'users_imageprofile' => 'image|mimes:jpeg,png,jpg,gif,svg|max:500',
    ];

    private $rulescompany = [
        'users_company_th' => 'required|max:255',
//    'users_company_en' => 'required|max:255',
        'users_imageprofile' => 'image|mimes:jpeg,png,jpg,gif,svg|max:500',
    ];

    public function __construct()
    {
        $this->middleware('user');
    }

    public function index(Request $request)
    {
        $item = auth()->guard('user')->user();
        $provinceItem = Province::orderBy('PROVINCE_NAME', 'ASC')
            ->get();
        $standards = Standard::all();
        $user_standard = UserStandard::where('user_id', $item->id)->get();
        for ($i = 0; $i < $standards->count(); $i++) {
            $standards[$i]->checked = false;
            foreach ($user_standard as $standard) {
                if ($standards[$i]->id == $standard->standard_id) {
                    $standards[$i]->checked = true;
                }
            }
        }
        return view('frontend.userprofile', compact('item', 'provinceItem', 'standards'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->guard('user')->user();
        if ($user->users_membertype == "personal") {
            $this->validate($request, $this->rules);
            $user->users_firstname_th = $request->input('users_firstname_th');
            $user->users_lastname_th = $request->input('users_lastname_th');
            $user->users_firstname_en = $request->input('users_firstname_en');
            $user->users_lastname_en = $request->input('users_lastname_en');
            $user->users_dateofbirth = DateFuncs::convertYear($request->input('users_dateofbirth'));
            $user->users_gender = $request->input('users_gender');
            $user->users_qrcode = $request->input('users_qrcode');
        }

        if ($user->users_membertype == "company") {
            $this->validate($request, $this->rulescompany);
            $user->users_firstname_th = $request->input('users_company_th');
            $user->users_company_th = $request->input('users_company_th');
            $user->users_company_th = $request->input('users_company_th');
            $user->users_fax = $request->input('users_fax');
            $user->users_qrcode = $request->input('users_qrcode');
        }

        if ($request->users_imageprofile != "") {
            $uploadImage = $this->UploadImage($request);
            $user->users_imageprofile = $uploadImage["image_path_filename"];
        }

        $user->requset_email_system = 0;
        if (!empty($request->input('requset_email_system'))) {
            $user->requset_email_system = $request->input('requset_email_system');
        }
        $user->users_addressname = $request->input('users_addressname');
        $user->users_street = $request->input('users_street');
        $user->users_district = $request->input('users_district');
        $user->users_city = $request->input('users_city');
        $user->users_province = $request->input('users_province');
        $user->users_postcode = $request->input('users_postcode');
        $user->users_mobilephone = $request->input('users_mobilephone');
        $user->users_phone = $request->input('users_phone');
        $user->users_latitude = $request->input('users_latitude');
        $user->users_longitude = $request->input('users_longitude');
        $user->save();

        return redirect()->route('userprofiles.index')
            ->with('success', trans('messages.message_update_success'));
    }

    private function RemoveFolderImage($rawfile)
    {
        if ($rawfile != "") {
            if (File::exists($rawfile)) {
                File::delete($rawfile);
            }
        }
    }

    public function UploadImage($request)
    {
        sleep(1);
        $filename = 'users_imageprofile';
        $image_path = $request->file($filename)->getPathname();
        $orgFilePathName = $request->{$filename}->getClientOriginalName();
        $ext = pathinfo($orgFilePathName, PATHINFO_EXTENSION);
        $image_directory = config('app.upload_imageprofile');
        $image_path_filename = $image_directory . microtime() . "." . $ext;
//        File::makeDirectory($image_directory, 0777, true, true);

        $img = Image::make($image_path);
        $img->save($image_path_filename);
        $img->destroy();

        return array('image_path_filename' => $image_path_filename);
    }
}
