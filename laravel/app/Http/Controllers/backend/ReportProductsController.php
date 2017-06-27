<?php
namespace App\Http\Controllers\backend;

use DB;
use App\Product;
use App\ProductCategory;
use Excel;
use Hash;
use Validator;
use Illuminate\Http\Request;
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
            $info = Excel::create('product-excell', function($excel) use($data) {
                $excel->sheet('Sheetname', function($sheet) use($data) {
                    $sheet->cell('A1:D1', function($cell) {
                        $cell->setFontWeight('bold');
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
}