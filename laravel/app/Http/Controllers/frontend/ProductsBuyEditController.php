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
use App\Standard;
use Illuminate\Support\Facades\Input;

class ProductsBuyEditController extends Controller
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
        //'volumnrange_start' => 'required|numeric',
        //'volumnrange_end' => 'required|numeric',
        //'units' => 'required',
        //'city' => 'required',
        //'province' => 'required',
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

        if ($id == 0) {
            $item = new ProductRequest();
            $item->id = 0;
            $item->productstatus = 'open';
            $item->iwantto = $useritem->iwanttobuy;
            $product_name = (object)array();
            $product_name->product_name_th = '';
        } else {
            $item = ProductRequest::find($id);
            $product_name = Product::where('id', '=', $item->products_id)->select('product_name_th')->first();

            if ($useritem->iwanttobuy != $item->iwantto) {
                return redirect()->action('frontend\UserProfileController@index');
            }
        }

        $productCategoryitem = ProductCategory::orderBy('sequence', 'ASC')
            ->get();

        $unitsItem = Units::orderBy('sequence', 'ASC')
            ->get();

        $standards = Standard::all();
        $grades = config('constants.grades');
        for($i = 0;$i < $standards->count();$i++){
            $standards[$i]->checked = false;
            foreach ($item->standards as $standard){
                if ($standards[$i]->id == $standard->id){
                    $standards[$i]->checked = true;
                }
            }
        }
        //return $standards;
        return view('frontend.productbuyedit', compact('item', 'useritem', 'productCategoryitem',
            'unitsItem', 'provinceItem', 'product_name','standards','grades'));
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

        $this->validate($request, $this->rules2);

        $productRequest->productcategorys_id = $request->productcategorys_id; //
        $productRequest->products_id = $request->products_id;
        $arr_checked_product_standards = Input::get('product_standard');
        if(!empty($request->product_other_standard)){
            $productRequest->product_other_standard = $request->product_other_standard;
        }
        $productRequest->packing_size = $request->packing_size;
        $productRequest->units = $request->units;
        $productRequest->grade = $request->grade;
        $productRequest->pricerange_start = $request->pricerange_start;
        $productRequest->pricerange_end = $request->pricerange_end;
        $productRequest->volumnrange_start = $request->volumnrange_start;
        $productRequest->province = $request->province;
        //$productRequest->product_description = $request->product_description;

        $productRequest->iwantto = $useritem->iwanttobuy;
        $productRequest->productstatus = $request->productstatus;
        $productRequest->productstatus = "open";
        $productRequest->users_id = $useritem->id;
        $productRequest->selling_type = $request->selling_type;

        //return $productRequest;

        if ($id == 0) {
            $productRequest->save();
            //Save to product_request_standard :: many to many relationship
            if(is_array($arr_checked_product_standards)){
                foreach ($arr_checked_product_standards as $item){
                    $productRequest->standards()->save(Standard::find($item));
                }
            }
            $id = $productRequest->id;
        } else {
            if(is_array($arr_checked_product_standards)){
                $productRequest->standards()->detach();
                foreach ($arr_checked_product_standards as $item){
                    $productRequest->standards()->save(Standard::find($item));
                }
            }
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

        return redirect()->route('productbuyedit.show', ['id' => $id])
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
        $request->{$imagecolumnname}->move(config('app.upload_product') . $fileTimeStamp . "/", $imageName);
        $imageName = config('app.upload_product') . $fileTimeStamp . "/" . $imageName;

        return array('imageTempName' => $imageTempName, 'imageName' => $imageName);
    }
}
