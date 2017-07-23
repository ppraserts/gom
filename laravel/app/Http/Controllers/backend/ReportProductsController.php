<?php
namespace App\Http\Controllers\backend;

use DB;
use App\Product;
use App\Market;
use App\ProductCategory;
use Excel;
use Hash;
use Validator;
use Illuminate\Http\Request;
use App\Helpers\DateFuncs;
//Boots
use App\Http\Controllers\backend\BaseReportsController as BaseReports;
class ReportProductsController extends BaseReports
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    private $rules = [
        'productcategorys_id' => 'required',
    ];

    public function index(Request $request)
    {
        if (!empty($request->input('is_search'))) {
            $validator = $this->getValidationFactory()->make($request->all(), $this->rules, [], []);
            if ($validator->fails()) {
                $request['productcategorys_id'] = $request['productcategorys_id'];
                $this->throwValidationException($request, $validator);
            }
        }
        $markets = Market::all();
        $productCategoryitem = BaseReports::productCategorys();
        $result = Product::leftJoin('comments', 'products.id', '=', 'comments.product_id')
            ->join('product_requests', 'product_requests.products_id', '=', 'products.id')
            ->join('product_request_market', 'product_request_market.product_request_id', '=', 'product_requests.id')
            ->join('markets', 'markets.id', '=', 'product_request_market.market_id');
        $result->select(DB::raw('products.id
              ,products.product_name_th
              ,products.product_name_en
              ,markets.market_title_th
              ,SUM(comments.score)/COUNT(comments.score) as product_score'));
        $productcategory_id= '';
        if(!empty($request->input('productcategorys_id'))){
            $productcategory_id = $request->input('productcategorys_id');
            $result->where('products.productcategory_id', $productcategory_id);
            //$products = BaseReports::productsByCategory($productcategory_id);
//            $product_id_arr = array();
//            if(!empty($request->input('product_id'))){
//                $product_id_arr = $request->input('product_id');
//                $result->whereIn('products.id', $product_id_arr);
//            }
        }
        $market_id='';
        if(!empty($request->input('market_id'))){
            $market_id = $request->input('market_id');
            $result->where('product_request_market.market_id', $market_id);
        }
        $result->orderBy('product_score', 'desc');
        $result->groupBy('products.id');
        $results = $result->paginate(config('app.paginate'));
        return view('backend.reports.product', compact('productCategoryitem'
            ,'results'
            ,'markets'
            ,'productcategory_id'
            //,'products'
            ,'market_id'
            ,'product_id_arr'));
    }

    public function exportExcel(Request $request)
    {
        if ($request->ajax()) {
            $productcategorys_id = $request->input('productcategorys_id');
            $market_id= $request->input('market_id');
            $results = $this->sqlFilter($productcategorys_id,$market_id);

            $product_category_name = trans('messages.all');
            if(!empty($productcategorys_id)){
               $productCategory = BaseReports::productCategory($productcategorys_id);
                $product_category_name = $productCategory->productcategory_title_th;
            }
            $market_name = trans('messages.menu_market').' : '.trans('messages.all');
            if(!empty($market_id)){
                $market = BaseReports::market($market_id);
                $market_name = trans('messages.menu_market').' : '.$market->market_title_th;
            }

            $arr[] = array(
                trans('messages.text_product_id'),
                trans('messages.text_product_th'),
                trans('messages.menu_market'),
                trans('messages.text_product_score'),
            );
            foreach ($results as $v) {
                if (!empty($v->product_score)) {
                    $product_score = $v->product_score.' '.trans('messages.text_star');
                } else{
                    $product_score = '0 '.trans('messages.text_star');
                }
                $arr[] = array(
                    $v->id,
                    $v->product_name_th,
                    $v->market_title_th,
                    $product_score
                );
            }

            $data = $arr;
            $info = Excel::create('dgtfarm-products-excel', function($excel) use($data,$product_category_name,$market_name) {
                $excel->sheet('Sheetname', function($sheet) use($data,$product_category_name,$market_name) {
                    $sheet->mergeCells('A1:D1');
                    $sheet->mergeCells('A2:D3');
                    $sheet->mergeCells('A4:D5');
                    $sheet->mergeCells('A6:D7');
                    $sheet->setSize(array(
                        'A1' => array(
                            'height'    => 50
                        )
                    ));
                    $sheet->setAutoSize(array('A'));

                    $sheet->cells('A1', function($cells) {
                        $cells->setValue(trans('messages.text_report_menu_product'));
                        $cells->setValignment('center');
                        $cells->setAlignment('center');
                        $cells->setFont(array(
                            'size'       => '16',
                            'bold'       =>  true
                        ));
                    });

                    $sheet->cells('A2', function($cells) use($product_category_name) {
                        $cells->setValue(trans('validation.attributes.productcategorys_id').': '.$product_category_name);
                        $cells->setFont(array(
                            'bold'       =>  true
                        ));
                        $cells->setValignment('center');
                    });

                    $sheet->cells('A4', function($cells) use($market_name) {
                        $cells->setValue($market_name);
                        $cells->setFont(array(
                            'bold'       =>  true
                        ));
                        $cells->setValignment('center');
                    });

                    $sheet->cells('A6', function($cells) {
                        $cells->setValue(trans('messages.datetime_export').': '.DateFuncs::dateToThaiDate(date('Y-m-d')).' '.date('H:i:s'));
                        $cells->setFont(array(
                            'bold'       =>  true
                        ));
                        $cells->setValignment('center');
                    });

                    $sheet->rows($data);
                });
            })->store('xls', false, true);
            return response()->json(array('file'=>$info['file']));
        }
    }

    private function sqlFilter($productcategory_id ='',$market_id=''){

        $result = Product::leftJoin('comments', 'products.id', '=', 'comments.product_id')
            ->join('product_requests', 'product_requests.products_id', '=', 'products.id')
            ->join('product_request_market', 'product_request_market.product_request_id', '=', 'product_requests.id')
            ->join('markets', 'markets.id', '=', 'product_request_market.market_id');
        $result->select(DB::raw('products.id
              ,products.product_name_th
              ,products.product_name_en
              ,markets.market_title_th
              ,SUM(comments.score)/COUNT(comments.score) as product_score'));

        if(!empty($productcategory_id)){
            $result->where('products.productcategory_id', $productcategory_id);
        }
        if(!empty($market_id)){
            $result->where('product_request_market.market_id', $market_id);
        }
        $result->groupBy('products.id');
        return $results = $result->orderBy('product_score', 'desc')->get();

    }

}