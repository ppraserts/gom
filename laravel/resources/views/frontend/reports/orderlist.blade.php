<?php
$pagetitle = trans('message.menu_order_list');
?>
@extends('layouts.main')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="glyphicon glyphicon-apple"></i>')
@section('content')
    @include('shared.usermenu', array('setActive'=>'reports'))
    <div class="col-sm-12">
        @if ($message = Session::get('success'))
            <div class="row">
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            </div>
        @endif
        <div class="row">
            <h2>{{ trans('messages.menu_order_list') }}</h2>
            <form action="{{url('user/reports/view')}}" class="form-horizontal" id="my-form" method="POST">
                {{csrf_field()}}
                <style>
                    .form-horizontal .form-group {
                         margin-right: 0px;
                         margin-left: 0px;
                    }
                </style>

                <div class="form-group form-group-sm col-md-6" style="padding-left: 0px;">
                    <label class="col-sm-2" style="padding-right: 0;">* วันเริ่มต้น :</label>
                    <div class="col-sm-10" style="padding-right: 0px;">
                        <div class='input-group date ' id='pick_start_date'>
                            {!! Form::text('start_date', '', array('placeholder' => 'วันเริ่มต้น','class' => 'col-md-10 form-control')) !!}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group form-group-sm col-md-6" style="padding-left: 0px; padding-right: 0;">
                    <label class="col-sm-2" style="padding-right: 0;">* วันสิ้นสุด :</label>
                    <div class="col-sm-10" style="padding-right: 0px;">
                        <div class='input-group date' id='pick_end_date'>
                            {!! Form::text('end_date', '', array('placeholder' => 'วันสิ้นสุด','class' => 'form-control')) !!}
                            <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                        </div>
                    </div>
                </div>

                <div class="form-group form-group-sm col-md-12" style="padding-left: 0px; padding-right: 0;">
                    <label class="col-sm-1" style="padding-right: 0;">* ชนิดสินค้า :</label>
                    <div class='col-sm-11' style="padding-right: 0;">
                        <select class="selectpicker form-control" name="product_type_name" data-live-search="true" multiple>
                            <option>Mustard</option>
                            <option>Ketchup</option>
                            <option>Relish</option>
                            <option>Relish</option>
                            <option>Relish</option>
                            <option>Relish</option>
                            <option>Relish</option>
                            <option>Relish</option>
                            <option>Relish</option>
                            <option>Relish</option>
                            <option>Relish</option>
                        </select>
                    </div>
                </div>
                <div class="form-group form-group-sm col-md-12" style="padding-left: 0px; padding-right: 0; padding-top: 5px;">
                    <label class="col-sm-1" style="padding-right: 0;">* หัวข้อ :</label>
                    <div class='col-sm-11' style="padding-right: 0;">
                        <input type="text" id="search" name="filter" class="form-control" value="{{Request::input('filter')}}"
                           placeholder="{{ trans('messages.order_id').'/'.trans('messages.i_sale').'/'.trans('messages.order_status') }}">
                    </div>
               </div>
                <div class="col-md-12" style="padding-left: 0; padding-right: 0;">
                    <button class="btn btn-default pull-right" type="submit">
                        <i class="fa fa-search"></i> ค้นหา
                    </button>
                </div>
            </form>
        </div>
        <div class="row" style="margin-top: 10px">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th width="120px" style="text-align:center;">{{ trans('messages.order_id') }}</th>
                        <th>{{ trans('messages.i_sale') }}</th>
                        <th style="text-align:center;">{{ trans('messages.order_date') }}</th>
                        <th style="text-align:center;">{{ trans('messages.order_total') }}</th>
                        <th style="text-align:center;">{{ trans('messages.order_status') }}</th>
                        <th width="130px" style="text-align:center;">
                            {{ trans('messages.view_order_detail') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($orderLists as $key => $item)
                        <tr>
                            <td style="text-align:center;">{{ $item->id }}</td>
                            <td>{{ $item->users_firstname_th. " ". $item->users_lastname_th }}</td>
                            <td style="text-align:center;">{{ $item->order_date }}</td>
                            <td style="text-align:center;">{{ $item->total_amount . trans('messages.baht') }}</td>
                            <td style="text-align:center;">{{ $item->status_name }}</td>
                            <td style="text-align:center;">
                                <a class="btn btn-info"
                                   href="{{ url ('user/orderdetail/'.$item->id) }}">
                                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $orderLists->appends(Request::all()) !!}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<link href="{{url('bootstrap-select/css/bootstrap-select.min.css')}}" type="text/css" rel="stylesheet">
<script src="{{url('bootstrap-select/js/bootstrap-select.min.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\OrderBuyRequest', '#my-form') !!}
<script type="text/javascript">
    $(function () {
        $('#pick_start_date').datepicker({
            format: 'yyyy-mm-dd',
            language: 'th-th',
            autoclose: true,
            toggleActive: false,
            todayHighlight: false,
            todayBtn: false,
            startView: 2,
            maxViewMode: 2
        });
        $('#pick_end_date').datepicker({
            format: 'yyyy-mm-dd',
            language: 'th-th',
            autoclose: true,
            toggleActive: false,
            todayHighlight: false,
            todayBtn: false,
            startView: 2,
            maxViewMode: 2
        });
    });
</script>
@endpush
