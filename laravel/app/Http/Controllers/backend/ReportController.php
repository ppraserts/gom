<?php

namespace App\Http\Controllers\backend;

use DB;
use App\Shop;
use Excel;
use Hash;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\ProductRequest;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $resultsG1 = DB::select(
            DB::raw("SELECT users_province,COUNT(*) as countuser
                   FROM users
                   GROUP BY `users_province`
                   ORDER BY users_province asc"));

        $resultsG2 = DB::select(
            DB::raw("SELECT users_membertype, COUNT( * ) as countuser
                  FROM users
                  GROUP BY  `users_membertype`
                  ORDER BY users_membertype ASC"));

        $resultsG3 = DB::select(
            DB::raw("SELECT 'Sale' iwantto, COUNT( * ) as countuser
                  FROM users
                  WHERE iwanttosale <> '' and iwanttobuy = ''
                  UNION
                  SELECT 'Buy' iwantto, COUNT( * ) as countuser
                  FROM users
                  WHERE iwanttobuy <> '' and iwanttosale = ''
                  UNION
                  SELECT 'Sale and Buy' iwantto, COUNT( * ) as countuser
                  FROM users
                  WHERE iwanttobuy <> '' and iwanttosale <> ''"));

        $Iwanttoobj = new ProductRequest();
        $itemssale = $Iwanttoobj->GetSearchProductRequests('sale', '', '', '', '', '', '');
        $itemsbuy = $Iwanttoobj->GetSearchProductRequests('buy', '', '', '', '', '', '');
        return view('backend.reportuser', compact('resultsG1'
            , 'resultsG2'
            , 'resultsG3'
            , 'itemssale'
            , 'itemsbuy'));
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
            ->paginate(config('app.paginate'));
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
        return  $results = $result->groupBy('shops.id')->paginate(100); //limit 100 per page

    }
}
