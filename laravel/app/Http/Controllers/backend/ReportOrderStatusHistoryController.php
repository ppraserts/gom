<?php
namespace App\Http\Controllers\backend;

use DB;
use App\Order;
use App\OrderPayment;
use Hash;
use Excel;
use Validator;
use App\Helpers\DateFuncs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//Boots
use App\Http\Controllers\backend\BaseReportsController as BaseReports;

class ReportOrderStatusHistoryController extends BaseReports
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    private $rules = [
        'start_date' => 'required',
        'end_date' => 'required|after:start_date'
    ];

    public function orderList(Request $request)
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

            $filter = $request->input('filter');
            $result = Order::join('order_status', 'order_status.id', '=', 'orders.order_status');
            $result->join('users', 'users.id', '=', 'orders.user_id');
            $result->select('orders.*', 'order_status.status_name', 'users.users_firstname_th', 'users.users_lastname_th');
            $result->where('orders.order_date', '>=', $request->input('start_date'));
            $result->where('orders.order_date', '<=', $request->input('end_date'));

            if (!empty($filter)) {
                $result->where(function ($query) use ($filter) {
                    $query->where('orders.id', 'like', '%' . $filter . '%');
                    $query->orWhere('order_status.status_name', 'like', '%' . $filter . '%');
                });
            }
            $result->orderBy('orders.id', 'DESC');
            $results = $result->paginate(config('app.paginate'));
            $request['start_date'] = DateFuncs::thai_date($request['start_date']);
            $request['end_date'] = DateFuncs::thai_date($request['end_date']);
            return view('backend.reports.order_status_history', compact('results'));
        } else {
            $defultDateMonthYear = BaseReports::dateToDayAndLastMonth();
            $defult_ymd_last_month = DateFuncs::convertToThaiDate($defultDateMonthYear['ymd_last_month']);
            $defult_ymd_today = DateFuncs::convertToThaiDate($defultDateMonthYear['ymd_today']);

            $results = Order::join('order_status', 'order_status.id', '=', 'orders.order_status')
                ->join('users', 'users.id', '=', 'orders.user_id')
                ->select('orders.*', 'order_status.status_name', 'users.users_firstname_th', 'users.users_lastname_th')
                ->where('orders.order_date', '>=', $defultDateMonthYear['ymd_last_month'])
                ->where('orders.order_date', '<=', $defultDateMonthYear['ymd_today'])
                ->orderBy('orders.id', 'DESC')
                ->paginate(config('app.paginate'));
            return view('backend.reports.order_status_history', compact('results','defult_ymd_last_month','defult_ymd_today'));
        }
    }

    public function exportExcel(Request $request)
    {
        if ($request->ajax()) {
            $filter = $request->input('filter');
            $start_date = DateFuncs::convertYear($request->input('start_date'));
            $end_date = DateFuncs::convertYear($request->input('end_date'));
            $results = $this->getDataToexcel($start_date, $end_date, $filter);

            $d_start = trans('messages.text_start_date') . ' : -';
            $d_end = trans('messages.text_end_date') . ' : -';
            if (!empty($request->input('start_date')) and !empty($request->input('end_date'))) {
                $d_start = trans('messages.text_start_date') . ' : ' .  DateFuncs::dateToThaiDate($start_date);
                $d_end = trans('messages.text_end_date') . ' : ' . DateFuncs::dateToThaiDate($end_date);
            }
            $filter_text = trans('messages.order_id') . '/' . trans('messages.order_status') . ' : ' . $filter;
            if (empty($filter)) {
                $filter_text = trans('messages.order_id') . '/' . trans('messages.order_status') . ' : ' . trans('messages.show_all');
            }

            $arr[] = array(
                trans('messages.order_id'),
                trans('messages.order_type'),
                trans('messages.i_sale'),
                trans('messages.i_buy'),
                trans('messages.order_date'),
                trans('messages.order_total').'('.trans('messages.baht').')',
                trans('messages.order_status'),
            );

            foreach ($results as $v) {
                $total_amount = $v->total_amount;
                if ($v->order_type == 'retail') {
                    $order_type = trans('messages.retail');
                } else {
                    $order_type = trans('messages.wholesale');
                }

                $fname_lname_sale = $v->users_firstname_th . " " . $v->users_lastname_th;
                $fname_lname_buy = $v->buyer->users_firstname_th . " " . $v->buyer->users_lastname_th;
                $order_date = DateFuncs::dateToThaiDate($v->order_date);
                $arr[] = array(
                    $v->id,
                    $order_type,
                    $fname_lname_sale,
                    $fname_lname_buy,
                    $order_date,
                    $total_amount,
                    $v->status_name
                );
            }

            $data = $arr;
            $info = Excel::create('order-status-history-excell', function ($excel) use ($data, $d_start, $d_end, $filter_text) {
                $excel->sheet('Sheetname', function ($sheet) use ($data, $d_start, $d_end, $filter_text) {
                    $sheet->mergeCells('A1:G1');
                    $sheet->mergeCells('A2:C3');
                    $sheet->mergeCells('D2:G3');
                    $sheet->setSize(array(
                        'A1' => array(
                            'height' => 50
                        )
                    ));
                    $sheet->setAutoSize(array('A'));

                    $sheet->cells('A1', function ($cells) {
                        $cells->setValue(trans('messages.text_report_menu_order_status_history'));
                        $cells->setValignment('center');
                        $cells->setAlignment('center');
                        $cells->setFont(array(
                            'size' => '16',
                            'bold' => true
                        ));
                    });
                    $sheet->cells('A2', function ($cells) use ($d_start, $d_end) {
                        $cells->setValue($d_start . ' ' . $d_end);
                        $cells->setFont(array(
                            'bold' => true
                        ));
                        $cells->setValignment('center');
                    });
                    $sheet->cells('D2', function ($cells) use ($filter_text) {
                        $cells->setValue($filter_text);
                        $cells->setFont(array(
                            'bold' => true
                        ));
                        $cells->setValignment('center');
                    });

                    $sheet->rows($data);//fromArray
                });
            })->store('xls', false, true);
            return response()->json(array('file' => $info['file']));
        }
    }

    private function getDataToexcel($start_date = '', $end_date = '', $filter = '')
    {
        if (!empty($start_date)) {
            $result = Order::join('order_status', 'order_status.id', '=', 'orders.order_status');
            $result->join('users', 'users.id', '=', 'orders.user_id');
            $result->select('orders.*', 'order_status.status_name', 'users.users_firstname_th', 'users.users_lastname_th');
            $result->where('orders.order_date', '>=', $start_date);
            $result->where('orders.order_date', '<=', $end_date);
            if (!empty($filter)) {
                $result->where(function ($query) use ($filter) {
                    $query->where('orders.id', 'like', '%' . $filter . '%');
                    $query->orWhere('order_status.status_name', 'like', '%' . $filter . '%');
                });
            }
            $result->orderBy('orders.id', 'DESC');
            return $results = $result->paginate(config('app.paginate'));
        }
        return $results = Order::join('order_status', 'order_status.id', '=', 'orders.order_status')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->select('orders.*', 'order_status.status_name', 'users.users_firstname_th', 'users.users_lastname_th')
            ->orderBy('orders.id', 'DESC')
            ->paginate(config('app.paginate'));
    }

}