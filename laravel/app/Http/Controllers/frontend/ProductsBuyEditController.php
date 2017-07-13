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
        'pricerange_start' => 'required',
        'pricerange_end' => 'required',
        'volumnrange_start' => 'required',
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
            $item->products_id = '';
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
        $user = auth()->guard('user')->user();

        $product_id = $request->products_id;
        $productExist = false;
        if ($request->products_id > 0){
            $product = Product::find($product_id);
            if ($product == null || $product->product_name_th != $request->fake_products_name){
                $productExist = false;
            }else{
                $productExist = true;
            }
        }else if ($product_id == ''){
            if ($request->fake_products_name != ''){
                $product = Product::where('product_name_th','=',$request->fake_products_name)
                    ->where('productcategory_id','=',$request->productcategorys_id)->first();
                if ($product!=null){
                    $productExist = true;
                    $product_id = $product->id;
                }
            }
        }

        if (!$productExist){
            $product = new Product();
            $product->product_name_th = $request->fake_products_name;
            $product->product_name_en = $request->fake_products_name;
            $product->productcategory_id = $request->productcategorys_id;
            $product->user_id = $user->id;
            $product->sequence = 999;
            $product->save();
            $product_id = $product->id;
        }
        if ($id == 0) {
            $productRequest = new ProductRequest();
            $productRequest->id = 0;
        } else {
            $productRequest = ProductRequest::find($id);
        }

        $this->validate($request, $this->rules);
        /*if ($id == 0)
            $this->validate($request, $this->rules);
        else{
            $this->validate($request, $this->rules3);
        }*/

        $productRequest->productcategorys_id = $request->productcategorys_id; //
        $productRequest->products_id = $request->products_id;
        $arr_checked_product_standards = Input::get('product_standard');
        if(!empty($request->product_other_standard)){
            $productRequest->product_other_standard = $request->product_other_standard;
        }
        $productRequest->packing_size = $request->packing_size;
        $productRequest->units = $request->units;
        if ($request->grade == 'ไม่มี'){
            $request->grade = '-';
        }
        $productRequest->grade = $request->grade;
        $productRequest->pricerange_start = $request->pricerange_start;
        $productRequest->pricerange_end = $request->pricerange_end;
        $productRequest->volumnrange_start = $request->volumnrange_start;
        $productRequest->province = $request->province;
        //$productRequest->product_description = $request->product_description;

        $productRequest->iwantto = $user->iwanttobuy;
        $productRequest->productstatus = $request->productstatus;
        $productRequest->productstatus = "open";
        $productRequest->products_id = $product_id;
        $productRequest->users_id = $user->id;
        $productRequest->selling_type = $request->selling_type;
        $productRequest->packing_size = $request->packing_size;
        if(!empty($request->add_packing)){
            $productRequest->add_packing = $request->add_packing;
        }
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

        $itemsbuy = $productRequest->matchWithBuy($user->id, []);
        $itemssale = $productRequest->matchingWithSale($user->id, []);

        foreach ($itemsbuy as $item) {
            if($item->products_id == $product_id)
                $this->SendEmailMatching($item);
        }

        foreach ($itemssale as $item) {
            if($item->products_id == $product_id)
                $this->SendEmailMatching($item);
        }

        return redirect('user/iwanttobuy')
            ->with('success', trans('messages.message_update_success'));
    }

    private function SendEmailMatching($item)
    {
        if ($item->requset_email_system ==1){
            $sendemailTo = $item->email;
            $sendemailFrom = env('MAIL_USERNAME');

            $data = array(
                'fullname' => $item->users_firstname_th . " " . $item->users_lastname_th
            );
            sleep(0.1);
            Mail::send('emails.matching', $data, function ($message) use ($sendemailTo, $sendemailFrom) {
                $message->from($sendemailFrom
                    , "DGTFarm");
                $message->to($sendemailTo)
                    ->subject("DGTFarm : " . trans('messages.email_subject_matching'));

            });
        }
    }
}
