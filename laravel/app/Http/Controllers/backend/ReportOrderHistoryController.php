<?php
namespace App\Http\Controllers\backend;

use DB;
use App\User;
use App\Order;
use Hash;
use Excel;
use Validator;
use App\Helpers\DateFuncs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportOrderHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $users = $this->users();

        if (!empty($request->input('is_search'))) {
            $v = Validator::make($request->all(), [
                'type_sale_buy' => 'required',
                'user' => 'required',
            ]);
            if ($v->fails()) {
                return redirect()->back()->withErrors($v->errors());
            }
            $type_sale_buy = $request->input('type_sale_buy');
            $user_id = $request->input('user');
            $results = $this->sqlFilterShowPaginate($type_sale_buy, $user_id);
            return view('backend.reports.order_history_sale_buy', compact('users', 'results', 'type_sale_buy', 'user_id'));
        }
        return view('backend.reports.order_history_sale_buy', compact('users'));
    }


    public function exportExcel(Request $request)
    {
        if ($request->ajax()) {
            $type_sale_buy = $request->input('type_sale_buy');
            $user_id = $request->input('user_id');
            $results = $this->sqlFilter($type_sale_buy, $user_id);
            if ($type_sale_buy == 'sale'){
                $i_sale_buy = trans('messages.i_sale');
                $arr[] = array(
                    trans('messages.order_id'),
                    trans('messages.order_type'),
                    trans('messages.i_sale'),
                    trans('messages.order_date'),
                    trans('messages.order_total').'('.trans('messages.baht').')',
                    trans('messages.order_status'),
                );
            }
            if ($type_sale_buy == 'buy'){
                $i_sale_buy = trans('messages.i_buy');
                $arr[] = array(
                    trans('messages.order_id'),
                    trans('messages.order_type'),
                    trans('messages.i_buy'),
                    trans('messages.order_date'),
                    trans('messages.order_total').'('.trans('messages.baht').')',
                    trans('messages.order_status'),
                );
            }
            foreach ($results as $v) {
                $total_amount = $v->total_amount;
                if($v->order_type== 'retail') {
                    $order_type = trans('messages.retail');
                }else {
                    $order_type = trans('messages.wholesale');
                }
                if ($type_sale_buy == 'sale'){
                    $fname_lname = $v->users_firstname_th. " ". $v->users_lastname_th;
                }
                if ($type_sale_buy == 'buy'){
                    $fname_lname = $v->buyer->users_firstname_th. " ". $v->buyer->users_lastname_th;
                }
                $order_date = DateFuncs::dateToThaiDate($v->order_date);
                $arr[] = array(
                    $v->id,
                    $order_type,
                    $fname_lname,
                    $order_date,
                    $total_amount,
                    $v->status_name
                );
            }

            $data = $arr;
            $info = Excel::create('order-history-sale-buy-excell', function($excel) use($data,$i_sale_buy,$fname_lname) {
                $excel->sheet('Sheetname', function($sheet) use($data,$i_sale_buy,$fname_lname) {
                    $sheet->mergeCells('A1:F1');
                    $sheet->mergeCells('A2:C3');
                    $sheet->mergeCells('D2:F3');
                    $sheet->setSize(array(
                        'A1' => array(
                            'height'    => 50
                        )
                    ));
                    $sheet->setAutoSize(array('A'));

                    $sheet->cells('A1', function($cells) {
                        $cells->setValue(trans('messages.text_report_menu_order_history_sale_buy'));
                        $cells->setValignment('center');
                        $cells->setAlignment('center');
                        $cells->setFont(array(
                            'size'       => '16',
                            'bold'       =>  true
                        ));
                    });
                    $sheet->cells('A2', function($cells) use($fname_lname) {
                        $cells->setValue($fname_lname);
                        $cells->setFont(array(
                            'bold'       =>  true
                        ));
                        $cells->setValignment('center');
                    });
                    $sheet->cells('D2', function($cells) use($i_sale_buy) {
                        $cells->setValue($i_sale_buy);
                        $cells->setFont(array(
                            'bold'       =>  true
                        ));
                        $cells->setValignment('center');
                    });

                    $sheet->rows($data);//fromArray
                });
            })->store('xls', false, true);
            return response()->json(array('file'=>$info['file']));
        }
    }

    private function sqlFilter($type_sale_buy = '',$userId=''){

        $result = Order::join('order_status', 'order_status.id', '=', 'orders.order_status');
        $result->join('users', 'users.id', '=', 'orders.user_id');
        $result->select('orders.*', 'order_status.status_name','users.users_firstname_th','users.users_lastname_th');

        if ($type_sale_buy == 'sale') { //user_id sale
            $result->where('orders.user_id', $userId);
            $result->where('users.iwanttosale', $type_sale_buy);
        }
        if ($type_sale_buy == 'buy') { //buyer_id buy
            $result->where('orders.buyer_id', $userId);
            $result->where('users.iwanttobuy', $type_sale_buy);
        }
        $result->orderBy('orders.id', 'DESC');
        return $results = $result->get();
    }

    private function sqlFilterShowPaginate($type_sale_buy = '',$userId=''){

        $result = Order::join('order_status', 'order_status.id', '=', 'orders.order_status');
        $result->join('users', 'users.id', '=', 'orders.user_id');
        $result->select('orders.*', 'order_status.status_name','users.users_firstname_th','users.users_lastname_th');

        if ($type_sale_buy == 'sale') { //user_id sale
            $result->where('orders.user_id', $userId);
            $result->where('users.iwanttosale', $type_sale_buy);
        }
        if ($type_sale_buy == 'buy') { //buyer_id buy
            $result->where('orders.buyer_id', $userId);
            $result->where('users.iwanttobuy', $type_sale_buy);
        }
        $result->orderBy('orders.id', 'DESC');
        return $results = $result->paginate(config('app.paginate'));
    }


    private function users(){
        return $users = User::select(DB::raw('users.id
            ,users.users_firstname_th
            ,users.users_lastname_th
            ,users.users_firstname_en
            ,users.users_lastname_en
            ,users.iwanttosale
            ,users.iwanttobuy'))
            ->where('is_active', 1)
            ->orderBy('users_firstname_th', 'ASC')->get();
    }
}