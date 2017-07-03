<?php

namespace App\Http\Controllers\backend;

use App\Product;
use App\ProductCategory;
use App\Province;
use App\Http\Controllers\Controller;
use App\ProductRequest;
use Illuminate\Http\Request;
use DB, Validator, Response;
use App\Helpers\DateFuncs;
use Excel;
use Storage;

class ReportMatchingController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    private $rules = [
        'start_date' => 'required',
        'end_date' => 'required|after:start_date'
    ];

    public function index(Request $request)
    {

        if (!empty($request->input('is_search'))) {

            $request['start_date'] = DateFuncs::convertYear($request['start_date']);
            $request['end_date'] = DateFuncs::convertYear($request['end_date']);

            $validator = $this->getValidationFactory()->make($request->all(), $this->rules, [], []);
            if ($validator->fails()) {
                $request['start_date'] = DateFuncs::thai_date($request['start_date']);
                $request['end_date'] = DateFuncs::thai_date($request['end_date']);
                $this->throwValidationException($request, $validator);
            }
        }


        $matching = ProductRequest::join('product_requests as b', function ($q) {
            $q->on('product_requests.products_id', '=', 'b.products_id')
                ->where('product_requests.iwantto', '=', 'sale')
                ->where('b.iwantto', '=', 'buy')
                ->where('product_requests.productstatus', '=', 'open')
                ->whereRaw('product_requests.price >= b.pricerange_start')
                ->whereRaw('product_requests.price <= b.pricerange_end');
        });
        $matching->join('products', 'product_requests.products_id', '=', 'products.id');
        $matching->join('users as seller', 'product_requests.users_id', '=', 'seller.id');
        $matching->join('users as buyer', 'b.users_id', '=', 'buyer.id');
        $matching->select(
            'seller.users_firstname_th as seller_firstname',
            'seller.users_lastname_th as seller_lastname',
            'buyer.users_firstname_th as buyer_firstname',
            'buyer.users_lastname_th as buyer_lastname',
            'b.volumnrange_start',
            'b.volumnrange_end',
            'b.pricerange_start',
            'b.pricerange_end',
            'product_requests.volumn',
            'product_requests.price',
            'product_requests.units',
            'product_requests.province',
            'product_requests.product_title',
            'products.product_name_th',
            'product_requests.products_id as products_id'
        );
        if (!empty($request->input('start_date')) && !empty($request->input('end_date'))) {
            $matching->where('product_requests.created_at', '>=', $request->input('start_date'));
            $matching->where('product_requests.created_at', '<=', $request->input('end_date'));
            $matching->where('b.created_at', '>=', $request->input('start_date'));
            $matching->where('b.created_at', '<=', $request->input('end_date'));
            $request['start_date'] = DateFuncs::thai_date($request['start_date']);
            $request['end_date'] = DateFuncs::thai_date($request['end_date']);
        }
        if (!empty($request->input('productcategorys_id'))){
            $productcategorys_id = $request->input('productcategorys_id');
            $products = Product::where('productcategory_id',$productcategorys_id)->get();
            $matching->where('products.productcategory_id', $productcategorys_id);
        }

        if (!empty($request->input('pid'))) {
            $productTypeNameArr = $request->input('pid');
            $matching->whereIn('products.id', $productTypeNameArr);
        }
        if (!empty($request->input('province_type_name'))) {
            $provinceTypeNameArr = $request->input('province_type_name');
            $matching->whereIn('product_requests.province_selling', $provinceTypeNameArr);
        }
        $matchings = $matching->paginate();
//            return $matchings;

        $provinces = Province::all();
        $productCategoryitem = ProductCategory::all();
        return view('backend.reports.matching', compact('matchings', 'products', 'provinces', 'productcategorys_id', 'productTypeNameArr', 'provinceTypeNameArr','productCategoryitem'));

    }

    public function exportExcel(Request $request)
    {
        if ($request->ajax()) {

            $productTypeNameArr = $request->input('product_type_name');

            $start_date = DateFuncs::convertYear($request->input('start_date'));
            $end_date = DateFuncs::convertYear($request->input('end_date'));

            $matching = ProductRequest::join('product_requests as b', function ($q) {
                $q->on('product_requests.products_id', '=', 'b.products_id')
                    ->where('product_requests.iwantto', '=', 'sale')
                    ->where('b.iwantto', '=', 'buy')
                    ->where('product_requests.productstatus', '=', 'open')
                    ->whereRaw('product_requests.price >= b.pricerange_start')
                    ->whereRaw('product_requests.price <= b.pricerange_end');
            });
            $matching->join('products', 'product_requests.products_id', '=', 'products.id');
            $matching->join('users as seller', 'product_requests.users_id', '=', 'seller.id');
            $matching->join('users as buyer', 'b.users_id', '=', 'buyer.id');
            $matching->select(
                'seller.users_firstname_th as seller_firstname',
                'seller.users_lastname_th as seller_lastname',
                'buyer.users_firstname_th as buyer_firstname',
                'buyer.users_lastname_th as buyer_lastname',
                'b.volumnrange_start',
                'b.volumnrange_end',
                'b.pricerange_start',
                'b.pricerange_end',
                'product_requests.volumn',
                'product_requests.price',
                'product_requests.units',
                'product_requests.province',
                'product_requests.product_title',
                'products.product_name_th',
                'product_requests.products_id as products_id'
            );
            $str_start_and_end_date = trans('messages.text_start_date') . ' : - ' . trans('messages.text_end_date') . ' : -';
            if (!empty($start_date) and !empty($end_date)) {
                $str_start_and_end_date = trans('messages.text_start_date') . ' : ' . $start_date . ' ' . trans('messages.text_end_date') . ' : ' . $end_date;
                $matching->where('product_requests.created_at', '>=', $start_date);
                $matching->where('product_requests.created_at', '<=', $end_date);
                $matching->where('b.created_at', '>=', $start_date);
                $matching->where('b.created_at', '<=', $end_date);
            }

            if (!empty($request->input('product_type_name'))) {
                $productTypeNameArr = $request->input('product_type_name');
                $matching->whereIn('products.id', $productTypeNameArr);
            }
            if (!empty($request->input('province_type_name'))) {
                $provinceTypeNameArr = $request->input('province_type_name');
                $matching->whereIn('product_requests.province_selling', $provinceTypeNameArr);
            }
            $matchings = $matching->get();

            $productStr = trans('messages.show_all');
            if (!empty($productTypeNameArr)) {
                $res = $this->getProductCate($productTypeNameArr);
                foreach ($res as $re) {
                    $productStrs[] = $re->product_name_th;
                }
                $productStr = implode(",", $productStrs);
            }

            $arr[] = array(
                trans('messages.no'),
                trans('validation.attributes.product_title'),
                trans('messages.text_product_type_name'),
                trans('messages.i_sale'),
                trans('messages.i_buy'),
                trans('validation.attributes.price'),
                trans('validation.attributes.volumnrange_product_need_buy')
            );
            $bahtStr = trans('messages.baht');
            foreach ($matchings as $i => $v) {
                $arr[] = array(
                    $i + 1,
                    $v->product_title,
                    $v->product_name_th,
                    $v->seller_firstname . " " . $v->seller_lastname,
                    $v->buyer_firstname . " " . $v->buyer_lastname,
                    $v->price . " " . $bahtStr . " / " . $v->units,
                    $v->volumnrange_start . " - " . $v->volumnrange_end . " " . $v->units
                );
            }
            $data = $arr;

            $info = Excel::create('dgtfarm-matching-excel', function ($excel) use ($data, $productStr, $str_start_and_end_date) {
                $excel->sheet('Sheetname', function ($sheet) use ($data, $productStr, $str_start_and_end_date) {

                    $sheet->mergeCells('A1:F1');
                    $sheet->mergeCells('A2:F3');
                    $sheet->mergeCells('A4:F5');
                    $sheet->mergeCells('A6:F7');
                    $sheet->setSize(array(
                        'A1' => array(
                            'height' => 50
                        )
                    ));
                    $sheet->setAutoSize(array('A'));
                    $sheet->cells('A1', function ($cells) {
                        $cells->setValue(trans('messages.matching_report'));
                        $cells->setValignment('center');
                        $cells->setAlignment('center');
                        $cells->setFont(array(
                            'size' => '16',
                            'bold' => true
                        ));
                    });

                    $sheet->cells('A2', function ($cells) use ($productStr) {
                        $cells->setValue(trans('messages.menu_add_product') . ': ' . $productStr);
                        $cells->setFont(array(
                            'bold' => true
                        ));
                        $cells->setValignment('center');
                    });
                    $sheet->cells('A4', function ($cells) use ($str_start_and_end_date) {
                        $cells->setValue($str_start_and_end_date);
                        $cells->setFont(array(
                            'bold' => true
                        ));
                        $cells->setValignment('center');
                    });
                    $sheet->cells('A6', function ($cells) {
                        $cells->setValue(trans('messages.datetime_export') . ': ' . DateFuncs::convertToThaiDate(date('Y-m-d')) . ' ' . date('H:i:s'));
                        $cells->setFont(array(
                            'bold' => true
                        ));
                        $cells->setValignment('center');
                    });

                    $sheet->rows($data);
                });
            })->store('xls', false, true);
            return response()->json(array('file' => $info['file']));
        }
    }

    public function actionDownload(Request $request)
    {
        $path = storage_path() . '/exports/' . $request->input('file');
        return response()->download($path);
    }
}
