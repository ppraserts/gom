<?php
namespace App\Http\Controllers\backend;

use DB;
use App\Shop;
use Excel;
use Hash;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportShopsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function reportShop()
    {
        $shops = Shop::get();
        $results = Shop::leftJoin('comments', 'shops.id', '=', 'comments.shop_id')
            ->select(DB::raw('shops.id
          ,shops.user_id
          ,shops.shop_title
          ,shops.shop_subtitle
          ,shops.shop_name
          ,SUM(comments.score)/COUNT(comments.score) as shop_score'))->groupBy('shops.id')
            ->orderBy('shop_score', 'desc')
            ->paginate(30);
        return view('backend.reports.shop', compact('shops','results'));
    }

    public function  shopFilter(Request $request){
        $v = Validator::make($request->all(), [
            'shop' => 'required'
        ]);
        if ($v->fails()){ return redirect()->back()->withErrors($v->errors()); }
        if($request->isMethod('post')) {
            $shopArr = $request->input('shop');
            $shops = Shop::get();
            $results = $this->shopSqlFilter($shopArr);
            return view('backend.reports.shop', compact('shops','results','shopArr'));
        }

    }

    public function shopExportExcel(Request $request)
    {
        if ($request->ajax()) {
            $shopArr = $request->input('shop_id_arr');
            $results = $this->shopSqlFilter($shopArr);
            $arr[] = array(
                trans('messages.text_shop_id'),
                trans('messages.text_shop_url'),
                trans('messages.text_shop_title'),
                trans('messages.text_shop_score'),
            );
            foreach ($results as $v) {
                if (!empty($v->shop_score)) {
                    $shop_score = $v->shop_score.' '.trans('messages.text_star');
                } else{
                    $shop_score = '0 '.trans('messages.text_star');
                }
                $arr[] = array(
                    $v->id,
                    url($v->shop_name),
                    $v->shop_title,
                    $shop_score
                );
            }
            $data = $arr;
            $info = Excel::create('shop-excell', function($excel) use($data) {
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

    public function actionDownload(Request $request)
    {
        $path  = storage_path().'/exports/'.$request->input('file');
        return response()->download($path);
    }

    private function shopSqlFilter($arrShopId =''){
        $result = Shop::leftJoin('comments', 'shops.id', '=', 'comments.shop_id');
        $result->select(DB::raw('shops.id
                  ,shops.user_id
                  ,shops.shop_title
                  ,shops.shop_subtitle
                  ,shops.shop_name
                  ,SUM(comments.score)/COUNT(comments.score) as shop_score'));
        if(!empty($arrShopId)){
            $result->whereIn('shops.id', $arrShopId);
        }
        $result->orderBy('shop_score', 'desc');
        return  $results = $result->groupBy('shops.id')->paginate(30); //limit 30 per page

    }
}
