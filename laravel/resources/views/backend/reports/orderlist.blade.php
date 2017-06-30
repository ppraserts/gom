<?php
$pagetitle = trans('messages.menu_order_list');
?>
@extends('layouts.dashboard')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="glyphicon glyphicon-apple"></i>')
@section('section')
    <div class="col-sm-12" style="padding: 10px 25px; border: 1px solid #ddd; margin-top: 15px;">
        <div class="row">
            @include('backend.reports.menu_reports')
        </div>
        @if (count($errors) > 0)
            <div class="row" style="margin-top: 15px;">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        <div class="row">
            <h2>{{ trans('messages.menu_order_list') }}</h2>
            <form action="{{url('admin/reports/buy')}}" class="form-horizontal" id="my-form" method="POST">
                {{csrf_field()}}
                <style>
                    .form-horizontal .form-group {
                        margin-right: 0px;
                        margin-left: 0px;
                    }
                </style>
                <div class="form-group form-group-sm col-md-6" style="padding-left: 0px;">
                    <label class="col-sm-2" style="padding-right: 0; padding-left: 0;">*
                        {{ trans('messages.text_start_date') }}:
                    </label>
                    <div class="col-sm-10" style="padding-right: 0px;">
                        <div class='input-group date ' id='pick_start_date'>
                            {!! Form::text('start_date', '', array('placeholder' => trans('messages.text_start_date'),'class' => 'form-control', 'id'=>'start_date')) !!}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                        <small class="alert-danger" id="ms_start_date"></small>
                    </div>
                </div>

                <div class="form-group form-group-sm col-md-6" style="padding-left: 0px; padding-right: 0;">
                    <label class="col-sm-2" style="padding-right: 0;padding-left: 0;">
                        * {{ trans('messages.text_end_date') }} :
                    </label>
                    <div class="col-sm-10" style="padding-right: 0px;">
                        <div class='input-group date' id='pick_end_date'>
                            {!! Form::text('end_date', '', array('placeholder' => trans('messages.text_end_date'),'class' => 'form-control', 'id'=>'end_date')) !!}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                        <small class="alert-danger" id="ms_end_date"></small>
                    </div>
                </div>

                <div class="form-group form-group-sm col-md-11" style="padding-left: 0px; padding-right: 0;">
                    <label class="col-sm-1"
                           style="padding-right: 0; padding-left: 0;">{{ trans('messages.text_product_type_name') }}
                        :</label>
                    <div class='col-sm-11' style="padding-right: 0;">
                        <select class="selectpicker form-control" name="product_type_name[]" id="product_type_name"
                                data-live-search="true"
                                multiple>
                            @if(count($products))
                                @foreach($products as $product)
                                    <option value="{{$product->id}}"
                                            @if(!empty($productTypeNameArr)) @if(in_array($product->id, $productTypeNameArr)) selected @endif @endif>
                                        {{$product->product_name_th}}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <small class="alert-danger" id="ms_product_type_name"></small>
                    </div>
                </div>

                <div class="col-md-1" style="padding-left: 0; padding-right: 0;">
                    <button class="btn btn-primary pull-right btn-sm" type="submit">
                        <i class="fa fa-search"></i> {{ trans('messages.search') }}
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
                        <th style="text-align:center;">{{ trans('messages.order_type') }}</th>
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
                    @if(count($orderLists) > 0)
                        @foreach ($orderLists as $key => $item)
                            <tr>
                                <td style="text-align:center;">{{ $item->id }}</td>
                                <td>
                                    @if($item->order_type== 'retail')
                                        {{trans('messages.retail')}}
                                    @else
                                        {{trans('messages.wholesale')}}
                                    @endif
                                </td>
                                <td>{{ $item->users_firstname_th. " ". $item->users_lastname_th }}</td>
                                <td style="text-align:center;">{{ $item->order_date }}</td>
                                <td style="text-align:center;">{{ $item->total_amount . trans('messages.baht') }}</td>
                                <td style="text-align:center;">{{ $item->status_name }}</td>
                                <td style="text-align:center;">
                                    <a class="btn btn-primary"
                                       href="{{ url ('admin/reports/orderdetail/'.$item->id) }}">
                                        <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            @if(count($orderLists) > 0)
                <div class="row">
                    <div class="col-md-6">{!! $orderLists->appends(Request::all()) !!}</div>
                    <div class="col-md-6">
                        <div class="col-md-12" style="padding-left: 0; padding-right: 0; margin-top: 20px;">
                            <button class="btn btn-primary pull-right" id="export" type="button">
                                {{trans('messages.export_excel')}}
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<link href="{{url('css/view-backend/reports.css')}}" type="text/css" rel="stylesheet">
<link href="{{url('bootstrap-select/css/bootstrap-select.min.css')}}" type="text/css" rel="stylesheet">
<script src="{{url('bootstrap-select/js/bootstrap-select.min.js')}}"></script>
<link href="{{url('css/bootstrap-datepicker.standalone.min.css')}}" rel="stylesheet">
<script src="{{url('js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{url('js/bootstrap-datepicker-thai.js')}}"></script>
<script src="{{url('js/bootstrap-datepicker.th.min.js')}}"></script>

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

    $("#start_date").change(function () {
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        if (end_date != '') {
            if (start_date <= end_date) {
                $("#ms_end_date").html('');
            } else {
                $("#start_date").focus();
                $("#ms_start_date").html('<?php echo Lang::get('validation.attributes.message_validate_start_date_1')?>');
            }
        }

    });
    $("#end_date").change(function () {
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        if (start_date != '') {
            if (end_date >= start_date) {
                $("#ms_start_date").html('');
                $("#ms_end_date").html('');
            } else {
                $("#end_date").focus();
                $("#ms_end_date").html('<?php echo Lang::get('validation.attributes.message_validate_end_date_1')?>');
            }
        }
    });



    //***********************************************
    $("#export").click(function () {
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        var filter = $("#filter").val();
        //var product_type_name = $("#product_type_name option:selected").val();
        var product_type_name = [];
        $('#product_type_name option:selected').each(function (i, selected) {
            product_type_name[i] = $(selected).val();
        });
        //console.log(product_type_name); return false;
        var key_token = $('input[name=_token]').val();
        $.ajax({
            headers: {'X-CSRF-TOKEN': key_token},
            type: "POST",
            url: "<?php $page = ''; if (!empty(Request::input('page'))) {
                $page = '?page=' . Request::input('page');
            } echo url('admin/reports/buy/export' . $page)?>",
            data: {start_date: start_date, end_date: end_date, product_type_name: product_type_name},
            success: function (response) {
//                    console.log(response);
                window.open(
                    "<?php echo url('admin/reports/buy/download/?file=')?>" + response.file,
                    '_blank'
                );
                return false;
            },
            error: function (response) {
                alert('error..');
                return false;
            }
        })
    });
</script>
@endpush
