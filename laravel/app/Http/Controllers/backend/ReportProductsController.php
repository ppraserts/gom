<?php
namespace App\Http\Controllers\backend;

use DB;
use App\Product;
use App\ProductCategory;
use Excel;
use Hash;
use Validator;
use Illuminate\Http\Request;
use App\Helpers\DateFuncs;
use App\Http\Controllers\Controller;

class ReportProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $productCategorys = ProductCategory::orderBy('sequence','ASC')->get();
        $results = Product::leftJoin('comments', 'products.id', '=', 'comments.product_id')
            ->select(DB::raw('products.id
          ,products.product_name_th
          ,products.product_name_en
          ,SUM(comments.score)/COUNT(comments.score) as product_score'))->groupBy('products.id')
            ->orderBy('product_score', 'desc')
            ->paginate(30);
        return view('backend.reports.product', compact('productCategorys','results'));
    }

    public function  filter(Request $request){
        $v = Validator::make($request->all(), [
            'product' => 'required'
        ]);
        if ($v->fails()){ return redirect()->back()->withErrors($v->errors()); }
        if($request->isMethod('post')) {
            $productArr = $request->input('product');
            $productCategorys = ProductCategory::orderBy('sequence','ASC')->get();
            $results = $this->sqlFilter($productArr);
            return view('backend.reports.product', compact('productCategorys','results','productArr'));
        }

    }

    public function exportExcel(Request $request)
    {
        if ($request->ajax()) {
            $product_arr= $request->input('product_arr');
            $results = $this->sqlFilter($product_arr);
            $str_type_producy = trans('messages.show_all');

            if(count($product_arr) > 0){
                $nameProductCategoryArrs = $this->getProductCategory($product_arr);
                foreach ($nameProductCategoryArrs as $nameProductCategoryArr){
                    $arrnameProductCategory[] = $nameProductCategoryArr->productcategory_title_th;
                }
                $str_type_producy = implode(",",$arrnameProductCategory);
            }

            $arr[] = array(
                trans('messages.text_product_id'),
                trans('messages.text_product_th'),
                trans('messages.text_product_en'),
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
                    $v->product_name_en,
                    $product_score
                );
            }

            $data = $arr;
            $info = Excel::create('dgtfarm-products-excel', function($excel) use($data,$str_type_producy) {
                $excel->sheet('Sheetname', function($sheet) use($data,$str_type_producy) {
                    $sheet->mergeCells('A1:D1');
                    $sheet->mergeCells('A2:D3');
                    $sheet->mergeCells('A4:D5');
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

                    $sheet->cells('A2', function($cells) use($str_type_producy) {
                        $cells->setValue(trans('messages.menu_add_product').': '.$str_type_producy);
                        $cells->setFont(array(
                            'bold'       =>  true
                        ));
                        $cells->setValignment('center');
                    });
                    $sheet->cells('A4', function($cells) {
                        $cells->setValue(trans('messages.datetime_export').': '.DateFuncs::convertToThaiDate(date('Y-m-d')).' '.date('H:i:s'));
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


    private function sqlFilter($arrProductCatId =''){
        $result = Product::leftJoin('comments', 'products.id', '=', 'comments.product_id');
        $result->select(DB::raw('products.id
              ,products.product_name_th
              ,products.product_name_en
              ,SUM(comments.score)/COUNT(comments.score) as product_score'))->groupBy('products.id');
        if(!empty($arrProductCatId)){
            $result->whereIn('products.productcategory_id', $arrProductCatId);
        }
        $result->orderBy('product_score', 'desc');
        return  $results = $result->groupBy('products.id')->paginate(30); //limit 100 per page

    }

    private function getProductCategory($arrId){
        return ProductCategory::select(DB::raw('productcategorys.productcategory_title_th'))
            ->whereIn('productcategorys.id', $arrId)
            ->orderBy('productcategorys.sequence', 'asc')
            ->get();
    }
}