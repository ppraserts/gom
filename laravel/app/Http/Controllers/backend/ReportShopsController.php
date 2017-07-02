<?php
namespace App\Http\Controllers\backend;

use DB;
use App\Shop;
use Excel;
use Hash;
use Validator;
use Illuminate\Http\Request;
use App\Helpers\DateFuncs;
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
//            $results = $this->shopSqlFilter($shopArr);
            $result = Shop::leftJoin('comments', 'shops.id', '=', 'comments.shop_id');
            $result->select(DB::raw('shops.id
                  ,shops.user_id
                  ,shops.shop_title
                  ,shops.shop_subtitle
                  ,shops.shop_name
                  ,SUM(comments.score)/COUNT(comments.score) as shop_score'));
            if(!empty($arrShopId)){
                $result->whereIn('shops.id', $shopArr);
            }
            $result->orderBy('shop_score', 'desc');
            $results = $result->groupBy('shops.id')->paginate(30); //limit 30 per page
            return view('backend.reports.shop', compact('shops','results','shopArr'));
        }

    }

    public function shopExportExcel(Request $request)
    {
        if ($request->ajax()) {
            $shopArr = $request->input('shop_id_arr');
            $results = $this->shopSqlFilter($shopArr);
            $str_shops = trans('messages.show_all');
            if(count($shopArr) > 0){
                $nameShopArrs = $this->getShops($shopArr);
                foreach ($nameShopArrs as $nameShopArr){
                    $arrNameShop[] = $nameShopArr->shop_name;
                }
                $str_shops = implode(",",$arrNameShop);
            }
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
            $info = Excel::create('dgtfarm-shops-excel', function($excel) use($data,$str_shops) {
                $excel->sheet('Sheetname', function($sheet) use($data,$str_shops) {
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
                        $cells->setValue(trans('messages.text_report_menu_shop'));
                        $cells->setValignment('center');
                        $cells->setAlignment('center');
                        $cells->setFont(array(
                            'size'       => '16',
                            'bold'       =>  true
                        ));
                    });

                    $sheet->cells('A2', function($cells) use($str_shops) {
                        $cells->setValue(trans('messages.shop').': '.$str_shops);
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
        //return  $results = $result->groupBy('shops.id')->paginate(30); //limit 30 per page
        return  $results = $result->groupBy('shops.id')->get();

    }
    private function getShops($arrId){
        return Shop::select(DB::raw('shops.shop_name'))
            ->whereIn('shops.id', $arrId)
            ->get();
    }
}
