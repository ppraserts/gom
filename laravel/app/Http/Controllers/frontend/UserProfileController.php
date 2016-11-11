<?php

namespace App\Http\Controllers\frontend;

use File;
use DB;
use Hash;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Model\frontend\User;

class UserProfileController extends Controller
{
  private $rules = [
    'users_firstname_th' => 'required|max:255',
    'users_lastname_th' => 'required|max:255',
    'users_dateofbirth' => 'required|date_format:Y-m-d',
    'users_imageprofile' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3048',
  ];

  private $rulescompany = [
    'users_company_th' => 'required|max:255',
    'users_company_en' => 'required|max:255',
    'users_imageprofile' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3048',
  ];

  public function __construct()
  {
      $this->middleware('user');
  }

  public function index(Request $request)
  {
      $item = auth()->guard('user')->user();
      return view('frontend.userprofile',compact('item'));
  }

  public function updateProfile(Request $request)
  {
    $user = auth()->guard('user')->user();
    if($user->users_membertype == "personal")
    {
      $this->validate($request, $this->rules);
      $user->users_firstname_th = $request->input('users_firstname_th');
      $user->users_lastname_th = $request->input('users_lastname_th');
      $user->users_firstname_en = $request->input('users_firstname_en');
      $user->users_lastname_en = $request->input('users_lastname_en');
      $user->users_dateofbirth = $request->input('users_dateofbirth');
      $user->users_gender = $request->input('users_gender');
    }

    if($user->users_membertype == "company")
    {
      $this->validate($request, $this->rulescompany);
      $user->users_company_th = $request->input('users_company_th');
      $user->users_company_th = $request->input('users_company_th');
      $user->users_fax = $request->input('users_fax');
    }

    if($request->users_imageprofile != "")
    {
      $uploadImage = $this->UploadImage($request);
      $this->RemoveFolderImage($request->users_imageprofile_temp);
      $user->users_imageprofile = $uploadImage["imageName"];
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
      if($rawfile != "")
      {
        $rawfileArr = explode("/", $rawfile);
        $indexFile = count($rawfileArr) - 1;
        $indexFolder = count($rawfileArr) - 2;
        File::delete($rawfile);
        File::deleteDirectory(config('app.upload_imageprofile').$rawfileArr[$indexFolder]);
      }
  }

  private function UploadImage(Request $request)
  {
      $fileTimeStamp = time();
      $imageTempName = $request->file('users_imageprofile')->getPathname();

      $imageName = $request->users_imageprofile->getClientOriginalName();
      $request->users_imageprofile->move(config('app.upload_imageprofile').$fileTimeStamp."/", $imageName);
      $imageName = config('app.upload_imageprofile').$fileTimeStamp."/".$imageName;

      return array('imageTempName'=> $imageTempName, 'imageName' => $imageName);
  }
}
