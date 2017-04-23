<?php

namespace App\Http\Controllers\frontend;

use File;
use DB;
use Hash;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Model\frontend\User;
use App\ProductRequest;
use App\ProductCategory;
use App\Units;
use App\Amphur;
use App\Province;
use App\District;
use App\Product;

class ProductsSaleEditController extends Controller
{
    private $rules = [
        'productcategorys_id' => 'required',
        'products_id' => 'required',
        //'product_title' => 'required',
        //'product_description' => 'required',
        'price' => 'required|numeric',
        'volumn' => 'required|numeric',
        'units' => 'required',
        'city' => 'required',
        'province' => 'required',
        'product1_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:3048',
        'product2_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3048',
        'product3_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3048',
    ];

    private $rules2 = [
        'productcategorys_id' => 'required',
        'products_id' => 'required',
        //'product_title' => 'required',
        //'product_description' => 'required',
        'pricerange_start' => 'required|numeric',
        'pricerange_end' => 'required|numeric',
        'volumnrange_start' => 'required|numeric',
        'volumnrange_end' => 'required|numeric',
        'units' => 'required',
        'city' => 'required',
        'province' => 'required',
    ];

    private $rules3 = [
        'productcategorys_id' => 'required',
        'products_id' => 'required',
        //'product_title' => 'required',
        //'product_description' => 'required',
        'price' => 'required|numeric',
        'volumn' => 'required|numeric',
        'units' => 'required',
        'city' => 'required',
        'province' => 'required',
        'product1_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3048',
        'product2_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3048',
        'product3_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3048',
    ];


    public function __construct()
    {
        $this->middleware('user');
    }

    public function show($id)
    {
        $useritem = auth()->guard('user')->user();
        $provinceItem = Province::orderBy('PROVINCE_NAME', 'ASC')
            ->get();
        $grades = config('constants.grades');

        if ($id == 0) {
            $item = new ProductRequest();
            $item->id = 0;
            $item->productstatus = 'open';
            $item->iwantto = $useritem->iwanttosale;
            $item->products_id = '';
            $product_name = (object)array();
            $product_name->product_name_th = '';

        } else {
            $item = ProductRequest::find($id);

            $product_name = Product::where('id', '=', $item->products_id)->select('product_name_th')->first();

            if ($useritem->iwanttosale != $item->iwantto) {
                return redirect()->action('frontend\UserProfileController@index');
            }
        }

        $productCategoryitem = ProductCategory::orderBy('sequence', 'ASC')
            ->get();

        $unitsItem = Units::orderBy('sequence', 'ASC')
            ->get();

        return view('frontend.productsaleedit', compact('item'
            , 'useritem', 'productCategoryitem', 'grades'
            , 'unitsItem', 'provinceItem', 'product_name'));
    }


    public function update(Request $request, $id)
    {
        $useritem = auth()->guard('user')->user();

        if ($id == 0) {
            $productRequest = new ProductRequest();
            $productRequest->id = 0;
        } else {
            $productRequest = ProductRequest::find($id);
        }

        if ($id == 0)
            $this->validate($request, $this->rules);
        else
            $this->validate($request, $this->rules3);

        if ($request->product1_file != "") {
            $uploadImage1 = $this->UploadImage($request, 'product1_file');
            $this->RemoveFolderImage($productRequest->product1_file);
            $productRequest->product1_file = $uploadImage1["imageName"];
        }
        if ($request->product2_file != "") {
            $uploadImage2 = $this->UploadImage($request, 'product2_file');
            $this->RemoveFolderImage($productRequest->product2_file);
            $productRequest->product2_file = $uploadImage2["imageName"];
        }
        if ($request->product3_file != "") {
            $uploadImage3 = $this->UploadImage($request, 'product3_file');
            $this->RemoveFolderImage($productRequest->product3_file);
            $productRequest->product3_file = $uploadImage3["imageName"];
        }


        $productRequest->iwantto = $useritem->iwanttosale;
        $productRequest->product_title = $request->product_title;
        $productRequest->product_description = $request->product_description;
        $productRequest->guarantee = $request->guarantee;
        $productRequest->price = $request->price;
        $productRequest->is_showprice = $request->is_showprice == "" ? 0 : 1;
        $productRequest->volumn = $request->volumn;
        $productRequest->productstatus = $request->productstatus;
        $productRequest->units = $request->units;
        $productRequest->city = $request->city;
        $productRequest->province = $request->province;
        $productRequest->productcategorys_id = $request->productcategorys_id;
        $productRequest->products_id = $request->products_id;
        $productRequest->users_id = $useritem->id;
        $productRequest->grade = $request->grade;
        $productRequest->is_packing = $request->is_packing;
        $productRequest->packing_size = $request->packing_size;
        $productRequest->province_selling = $request->province_selling;
        $productRequest->start_selling_date = $request->start_selling_date;
        $productRequest->end_selling_date = $request->end_selling_date;
        $productRequest->selling_type = $request->selling_type;

        if ($id == 0) {
            $productRequest->save();
            $id = $productRequest->id;
        } else {
            $productRequest->update();
        }

        $itemsbuy = $productRequest->GetSaleMatchingWithBuy($useritem->id, '');
        $itemssale = $productRequest->GetBuyMatchingWithSale($useritem->id, '');

        foreach ($itemsbuy as $div_item) {
            $this->SendEmailMatching($div_item);
        }

        foreach ($itemssale as $div_item) {
            $this->SendEmailMatching($div_item);
        }


        return redirect()->route('productsaleedit.show', ['id' => $id])
            ->with('success', trans('messages.message_update_success'));
    }

    private function SendEmailMatching($div_item)
    {
        $sendemailTo = $div_item->email;
        $sendemailFrom = env('MAIL_USERNAME');

        $data = array(
            'fullname' => $div_item->users_firstname_th . " " . $div_item->users_lastname_th
        );
        sleep(0.1);
        Mail::send('emails.matching', $data, function ($message) use ($sendemailTo, $sendemailFrom) {
            $message->from($sendemailFrom
                , "Greenmart Online Market");
            $message->to($sendemailTo)
                ->subject("Greenmart Online Market : " . trans('messages.email_subject_matching'));

        });
    }

    private function RemoveFolderImage($rawfile)
    {
        sleep(1);
        if ($rawfile != "") {
            $rawfileArr = explode("/", $rawfile);
            $indexFile = count($rawfileArr) - 1;
            $indexFolder = count($rawfileArr) - 2;
            File::delete($rawfile);
            File::deleteDirectory(config('app.upload_product') . $rawfileArr[$indexFolder]);
        }
    }

    private function UploadImage(Request $request, $imagecolumnname)
    {
        sleep(1);
        $fileTimeStamp = time();
        $imageTempName = $request->file($imagecolumnname)->getPathname();

        $imageName = $request->{$imagecolumnname}->getClientOriginalName();

        //$imageName_temp = iconv('UTF-8', 'tis620',$imageName);
        $imageName_temp = $imageName;

        $request->{$imagecolumnname}->move(config('app.upload_product') . $fileTimeStamp . "/", $imageName_temp);
        $imageName = config('app.upload_product') . $fileTimeStamp . "/" . $imageName;

        return array('imageTempName' => $imageTempName, 'imageName' => $imageName);
    }
}
