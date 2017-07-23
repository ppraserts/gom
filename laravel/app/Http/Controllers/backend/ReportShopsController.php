<?php
namespace App\Http\Controllers\backend;

use App\Market;
use App\Province;
use App\UserMarket;
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

    private $rules = [
        'shop' => 'required',
    ];

    public function reportShop(Request $request)
    {
        $shops = Shop::get();
        $result = Shop::leftJoin('comments', 'shops.id', '=', 'comments.shop_id');
        $result->join('users', 'users.id', '=', 'shops.user_id');
        $result->join('user_market', 'user_market.user_id', '=', 'shops.user_id');
        $result->select(DB::raw('shops.id
                  ,shops.user_id
                  ,shops.shop_title
                  ,shops.shop_subtitle
                  ,shops.shop_name
                  ,users.users_province
                  ,SUM(comments.score)/COUNT(comments.shop_id) as shop_score'));
        $shopArr = array();
        if (!empty($request->input('shop'))) {
            $shopArr = $request->input('shop');
            $result->whereIn('shops.id', $shopArr);
        }

        if (!empty($request->input('province_type_name'))) {

            $provinceTypeName = $request->input('province_type_name');
            if ($provinceTypeName != '') {
                $result->where('users.users_province', $provinceTypeName);
            } else {

                echo "5555";
                exit();
            }
        }

        if (!empty($request->input('user_market'))) {
            $user_market = $request->input('user_market');
            $result->where('user_market.market_id', $user_market);
        }

        $result->orderBy('shop_score', 'desc');
        $result->groupBy('shops.id');
        $results = $result->paginate(config('app.paginate'));

        foreach ($results as $result) {
            $userMarkets = UserMarket::join('markets', 'user_market.market_id', '=', 'markets.id')
                ->select('market_title_th as market_name')
                ->where('user_market.user_id',$result->user_id)
                ->get();
            $result->markets = $userMarkets;
        }

        $markets = Market::all();
        $provinces = Province::all();



        return view('backend.reports.shop', compact('shops', 'results', 'shopArr', 'markets', 'provinces', 'provinceTypeName', 'user_market'));
    }

    public function shopExportExcel(Request $request)
    {
        if ($request->ajax()) {
            $result = Shop::leftJoin('comments', 'shops.id', '=', 'comments.shop_id');
            $result->join('users', 'users.id', '=', 'shops.user_id');
            $result->join('user_market', 'user_market.user_id', '=', 'shops.user_id');
            $result->select(DB::raw('shops.id
                  ,shops.user_id
                  ,shops.shop_title
                  ,shops.shop_subtitle
                  ,shops.shop_name
                  ,users.users_province
                  ,SUM(comments.score)/COUNT(comments.shop_id) as shop_score'));
            $shopArr = array();
            if (!empty($request->input('shop'))) {
                $shopArr = $request->input('shop');
                $result->whereIn('shops.id', $shopArr);
            }

            if (!empty($request->input('province_type_name'))) {

                $provinceTypeName = $request->input('province_type_name');
                if ($provinceTypeName != '') {
                    $result->where('users.users_province', $provinceTypeName);
                } else {

                    echo "5555";
                    exit();
                }
            }

            if (!empty($request->input('user_market'))) {
                $user_market = $request->input('user_market');
                $result->where('user_market.market_id', $user_market);
            }

            $result->orderBy('shop_score', 'desc');
            $result->groupBy('shops.id');
            $results = $result->paginate(config('app.paginate'));

            foreach ($results as $result) {
                $userMarkets = UserMarket::join('markets', 'user_market.market_id', '=', 'markets.id')
                    ->select('market_title_th as market_name')
                    ->where('user_market.user_id',$result->user_id)
                    ->get();
                $marketArrStr = array();
                foreach ($userMarkets as $userMarket){
                    array_push($marketArrStr,'- '.$userMarket->market_name);
                }
                $result->markets = implode(", ",$marketArrStr);

            }

            $markets = Market::all();
            $provinces = Province::all();

            $str_shops = trans('messages.show_all');
            if (count($shopArr) > 0) {
                $nameShopArrs = $this->getShops($shopArr);
                foreach ($nameShopArrs as $nameShopArr) {
                    $arrNameShop[] = $nameShopArr->shop_name;
                }
                $str_shops = implode(",", $arrNameShop);
            }

            // filter market
            $str_market = trans('messages.all');
            if (!empty($user_market)) {
                foreach ($markets as $market) {
                    if ($market->id = $user_market) {
                        $str_market = $market->market_title_th;
                    }
                }
            }

            $str_province = trans('messages.allprovince');
            if (!empty($provinceTypeName)) {
                $str_province = $provinceTypeName;
            }
            $arr[] = array(
                trans('messages.text_shop_url'),
                trans('messages.text_shop_title'),
                trans('messages.menu_market'),
                trans('messages.text_shop_score'),
            );
            foreach ($results as $v) {
                if (!empty($v->shop_score)) {
                    $shop_score = $v->shop_score . ' ' . trans('messages.text_star');
                } else {
                    $shop_score = '0 ' . trans('messages.text_star');
                }
                $arr[] = array(
                    url($v->shop_name),
                    $v->shop_title,
                    $v->markets,
                    $shop_score
                );
            }
            $data = $arr;
            $info = Excel::create('dgtfarm-shops-excel', function ($excel) use ($data, $str_shops, $str_market, $str_province) {
                $excel->sheet('Sheetname', function ($sheet) use ($data, $str_shops, $str_market, $str_province) {
                    $sheet->mergeCells('A1:D1');
                    $sheet->mergeCells('A2:D3');
                    $sheet->mergeCells('A4:D5');
                    $sheet->setSize(array(
                        'A1' => array(
                            'height' => 50
                        )
                    ));
                    $sheet->setAutoSize(array('A'));

                    $sheet->cells('A1', function ($cells) {
                        $cells->setValue(trans('messages.text_report_menu_shop'));
                        $cells->setValignment('center');
                        $cells->setAlignment('center');
                        $cells->setFont(array(
                            'size' => '16',
                            'bold' => true
                        ));
                    });

                    $sheet->cells('A2', function ($cells) use ($str_shops, $str_market, $str_province) {
                        $cells->setValue(trans('messages.shop') . ': ' . $str_shops . ", " . trans('messages.province') . ': ' . $str_province . ", " . trans('messages.menu_market') . ': ' . $str_market);
                        $cells->setFont(array(
                            'bold' => true
                        ));
                        $cells->setValignment('center');
                    });
                    $sheet->cells('A4', function ($cells) {
                        $cells->setValue(trans('messages.datetime_export') . ': ' . DateFuncs::dateToThaiDate(date('Y-m-d')) . ' ' . date('H:i:s'));
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


    private function getShops($arrId)
    {
        return Shop::select(DB::raw('shops.shop_name'))
            ->whereIn('shops.id', $arrId)
            ->get();
    }
}
