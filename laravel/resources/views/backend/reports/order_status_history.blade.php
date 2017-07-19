@extends('layouts.dashboard')
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
        <div class="row text-center">
            <h2>{{ trans('messages.text_report_menu_order_status_history') }}</h2>
        </div>
        {{csrf_field()}}
        <form action="{{url('admin/reports/orders')}}" id="myForm" method="GET" data-toggle="validator" role="form">

            <input type="hidden" name="is_search" value="true"/>
            <div class="row">
                <div class="form-group form-group-sm col-md-4" style="padding-left: 0px;">
                    <strong style="padding-right: 0; padding-left: 0;">
                        * {{ trans('messages.text_start_date') }}:
                    </strong>

                    <div class='input-group date ' id='pick_start_date'>
                        {!! Form::text('start_date', $defult_ymd_last_month, array('placeholder' => trans('messages.text_start_date'),'class' => 'form-control', 'id'=>'start_date','data-error'=>trans('validation.attributes.message_validate_start_date'),'required'=>'required')) !!}
                        <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                    </div>
                    <div class="help-block with-errors"></div>
                    <span id="with_errors_start_date"> </span>
                </div>

                <div class="form-group form-group-sm col-md-4" style="padding-left: 0px;">
                    <strong style="padding-right: 0;padding-left: 0;">
                        * {{ trans('messages.text_end_date') }} :
                    </strong>

                    <div class='input-group date' id='pick_end_date'>
                        {!! Form::text('end_date', $defult_ymd_today, array('placeholder' => trans('messages.text_end_date'),'class' => 'form-control', 'id'=>'end_date','data-error'=>trans('validation.attributes.message_validate_end_date'),'required'=>'required')) !!}
                        <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                    </div>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group form-group-sm col-md-4" style="padding-left: 0px; padding-right: 0;">
                    <strong text-left" style="padding-right: 0;padding-left: 0;">
                    {{ trans('messages.order_id').'/'.trans('messages.order_status') }} :
                    </label>
                    <div style="padding-right: 0px;">
                        <input type="text" id="filter" name="filter" class="form-control" value=""
                               placeholder="{{ trans('messages.order_id').'/'.trans('messages.order_status') }}">
                    </div>

                </div>

            </div>
            <div class="row">
                <div class="text-center" style="padding-left: 0px; padding-right: 0;">
                    <button style="width: 200px;" class="btn btn-primary" type="submit">
                        <i class="fa fa-search"></i> {{ trans('messages.search') }}
                    </button>
                </div>
            </div>
        </form>


        <div class="row" style="margin-top: 10px">
            @if(count($results) > 0 && count($errors) < 1)
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" style="font-size: 13px;">
                    <thead>
                    <tr>
                        <th width="120px" style="text-align:center;">{{ trans('messages.order_id') }}</th>
                        <th style="text-align:center;">{{ trans('messages.order_type') }}</th>
                        <th>{{ trans('messages.i_sale') }}</th>
                        <th>{{ trans('messages.i_buy') }}</th>
                        <th style="text-align:center;">{{ trans('messages.order_date') }}</th>
                        <th style="text-align:center;">{{ trans('messages.order_total').'('.trans('messages.baht').')' }}</th>
                        <th style="text-align:center;">{{ trans('messages.order_status') }}</th>
                        <th width="130px" style="text-align:center;">
                            {{ trans('messages.view_order_detail') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody style="font-weight: normal">
                        @foreach ($results as $result)
                            <tr>
                                <td style="text-align:center;">{{ $result->id }}</td>
                                <td style="text-align:center;">
                                    {{ $result->order_type== 'retail'? trans('messages.retail'): trans('messages.wholesale')}}
                                </td>
                                <td>{{ $result->users_firstname_th. " ". $result->users_lastname_th }}</td>
                                <th style="font-weight: normal">
                                    {{ $result->buyer->users_firstname_th. " ". $result->buyer->users_lastname_th }}
                                </th>
                                <td style="text-align:center;">{{ \App\Helpers\DateFuncs::dateToThaiDate($result->order_date) }}</td>
                                <td style="text-align:center;">{{ number_format($result->total_amount) }}</td>
                                <td style="text-align:center;">{{ $result->status_name }}</td>
                                <td style="text-align:center;">
                                    <a class="btn btn-info"
                                       href="{{ url ('admin/reports/orderdetail/'.$result->id) }}">
                                        <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                @else
                    <div class="alert alert-warning text-center">
                        <strong>{{trans('messages.data_not_found')}}</strong>
                    </div>
                @endif
            </div>
        </div>
        @if(count($results) > 0 && count($errors) < 1)
            <div class="row">
                <div class="col-md-6">{!! $results->appends(Request::all()) !!}</div>
                <div class="col-md-6">
                    <div class="col-md-12" style="padding-left: 0; padding-right: 0; margin-top: 20px;">
                        @if(count($results) > 0)
                            <button class="btn btn-primary pull-right" id="export" type="button">
                                <span class="glyphicon glyphicon-export"></span>
                                {{ trans('messages.export_excel') }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        <input type="hidden" id="btn_close" value="{{trans('messages.btn_close')}}">
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
<script src="{{url('jquery-plugin-for-bootstrap-loading-modal/build/bootstrap-waitingfor.js')}}"></script>
<script src="{{url('bootstrap-validator/js/validator.js')}}"></script>
<script type="text/javascript">
    $(function () {
        $('#myForm').submit(function () {
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();
            if (start_date != '') {
                if (start_date > end_date) {
                    $("#start_date").focus();
                    $('#with_errors_start_date').css('color', '#a94442');
                    $('#with_errors_start_date').html("<?php echo Lang::get('validation.attributes.message_validate_start_date_1')?>");
                    return false;
                }
            }

        });
    });
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

    $("#export").click(function () {
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        var filter = $("#filter").val();
        var key_token = $('input[name=_token]').val();

        waitingDialog.show('<?php echo trans('messages.text_loading_lease_wait')?>', {
            progressType: 'success'
        });

        $.ajax({
            headers: {'X-CSRF-TOKEN': key_token},
            type: "POST",
            url: "<?php $page = ''; if (!empty(Request::input('page'))) {
                $page = '?page=' . Request::input('page');
            } echo url('admin/reports/orders/export' . $page)?>",
            data: {start_date: start_date, end_date: end_date, filter: filter},
            success: function (response) {
                $('.modal-content').empty();
                $('.modal-content').html('<div class="modal-body text-center"><button class="btn btn-info a-download" id="btn-download" style="margin-right: 5px;"><?php echo trans('messages.text_download')?></button><button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo trans('messages.text_close')?></button></div>');
                $(".a-download").click(function () {
                    waitingDialog.hide();
                    window.open(
                        "<?php echo url('admin/reports/shop/download/?file=')?>" + response.file,
                        '_blank'
                    );
                });
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
