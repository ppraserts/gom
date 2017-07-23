<?php
$pagetitle = trans('message.menu_order_list');
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
        <div class="row text-center">
            <h2>{{trans('messages.report_sale_shop')}}</h2>
        </div>
        {{csrf_field()}}
        <form action="{{url('admin/reports/salebyshop')}}" class="form-horizontal" id="myForm" method="GET" data-toggle="validator" role="form">

            <input type="hidden" name="is_search" value="true"/>
            <style>
                .form-horizontal .form-group {
                    margin-right: 0px;
                    margin-left: 0px;
                }
            </style>
            <div class="row">
                <div class="form-group form-group-sm col-md-6" style="padding-left: 0px;">
                    <label style="padding-right: 0; padding-left: 0;">
                        * {{ trans('messages.text_start_date') }} :
                    </label>
                    <div style="padding-right: 0px;">
                        <div class='input-group date ' id='pick_start_date'>
                            {!! Form::text('start_date', $defult_ymd_last_month, array('placeholder' => trans('messages.text_start_date'),'class' => 'form-control', 'id'=>'start_date','data-error'=>trans('validation.attributes.message_validate_start_date'),'required'=>'required')) !!}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                        <div class="help-block with-errors"></div>
                        <span id="with_errors_start_date"> </span>
                    </div>
                </div>

                <div class="form-group form-group-sm col-md-6" style="padding-left: 0px; padding-right: 0;">
                    <label style="padding-right: 0;padding-left: 0;">
                        * {{ trans('messages.text_end_date') }} :
                    </label>
                    <div style="padding-right: 0px;">
                        <div class='input-group date' id='pick_end_date'>
                            {!! Form::text('end_date', $defult_ymd_today, array('placeholder' => trans('messages.text_end_date'),'class' => 'form-control', 'id'=>'end_date','data-error'=>trans('validation.attributes.message_validate_end_date'),'required'=>'required')) !!}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group form-group-sm col-md-6" style="padding-left: 0px;">
                    <label style="padding-right: 0; padding-left: 0;">
                        {{ trans('messages.province') }} :
                    </label>
                    <div style="padding-right: 0;">
                        <select class="selectpicker form-control" name="users_province" id="users_province"
                                data-live-search="true">
                            <option value="">
                                {{ trans('messages.allprovince') }}
                            </option>
                            @if(count($provinces) > 0)
                                @foreach($provinces as $province)
                                    <option value="{{$province->PROVINCE_NAME}}"
                                            @if(!empty($users_province) and $users_province == $province->PROVINCE_NAME) selected @endif>
                                        {{$province->PROVINCE_NAME}}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <small class="alert-danger" id="ms_users_province"></small>
                    </div>
                </div>
                <div class="form-group form-group-sm col-md-6" style="padding-left: 0px; padding-right: 0;">
                    <label style="padding-right: 0; padding-left: 0;">
                        {{ trans('messages.shop_name') }} :
                    </label>
                    <div style="padding-right: 0;">
                        <select class="selectpicker form-control" name="shop_select_id[]" id="shop_select_id"
                                data-live-search="true" title=" "
                                multiple>
                            @if(count($allShops) > 0)
                                @foreach($allShops as $shop)
                                    <option value="{{$shop->id}}"
                                            @if(!empty($shopNameArr)) @if(in_array($shop->id, $shopNameArr)) selected @endif @endif>
                                        {{$shop->shop_name}}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <small class="alert-danger" id="ms_shop_select_id"></small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="text-center" style="padding-left: 0px; padding-right: 0; margin-top: 15px;">
                    <strong>{{trans('messages.type_report')}}</strong>
                    <input type="radio" name="format_report" value="1" checked> {{trans('messages.type_report_chart')}}
                    <input type="radio" name="format_report" value="2" @if(Request::input('format_report') == 2) checked @endif> {{trans('messages.type_report_table')}}

                </div>
            </div>
            <div class="row">
                <div class="text-center" style="padding-left: 0px; padding-right: 0; margin-top: 25px; margin-bottom: 25px;">
                <button style="width: 200px;" class="btn btn-primary" type="submit">
                        <i class="fa fa-search"></i> {{ trans('messages.search') }}
                    </button>
                </div>
            </div>
        </form>
        @if(Request::input('format_report') == 1 or empty(Request::input('format_report')))
            @include('backend.reports.ele_report_shop_chart')
        @elseif(Request::input('format_report') == 2)
            @include('backend.reports.ele_report_shop_table')
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

<script src="{{ url('charts/js/highcharts.js')}}"></script>
<script src="{{ url('charts/js/modules/exporting.js')}}"></script>
<script src="{{url('bootstrap-validator/js/validator.js')}}"></script>
<script src="{{url('jquery-plugin-for-bootstrap-loading-modal/build/bootstrap-waitingfor.js')}}"></script>
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
<?php if(count($shops) > 0 and (Request::input('format_report') == 1 or empty(Request::input('format_report')))){ $province_name=''; if(!empty($users_province)){ $province_name ='('.trans('messages.province').' '.$users_province.')'; }?>
<script src="{{ url('charts/js/highcharts.js')}}"></script>
<script src="{{ url('charts/js/modules/exporting.js')}}"></script>

<style type="text/css">
    ${
demo.css
}
</style>
<script type="text/javascript">
    $(function () {
        $('#myForm').submit(function () {
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();
            if(start_date !='') {
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
        $('#container').highcharts({
            chart: {
//                type: 'column'
                type: 'bar'
            },
            title: {
                text: 'ยอดจำหน่ายสินค้า {{$province_name}} {{(isset($start_date) && isset($end_date)) ? ('วันที่ '. \App\Helpers\DateFuncs::mysqlToThaiDateString($start_date) . ' ถึง '.\App\Helpers\DateFuncs::mysqlToThaiDateString($end_date)) : ""}}'
            },
            subtitle: {
                text: '<span style="color:#353535; font-weight:bold; font-size:14px; ">ยอดรวม : {{ number_format($sumAll)}} บาท </span>'
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'ยอดจำหน่ายสินค้า'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        rotation: 30,
                        color: '#FFFFFF',
                        align: 'center',
                        format: '{point.y:.1f} บาท',
                        y: 0, //35
                        style: {
                            fontSize: '10px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px"><b></b></span>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span> : <b>{point.y:.2f} บาท</b><br/>'
            },

            series: [{
                name: '',
                colorByPoint: true,
                data: [<?php $n = 1; foreach ($shops as $val){ ?>{
                    name: '<?php echo $val->shop_name?>',
                    y: <?php echo $val->total?>,
                    drilldown: '<?php echo $val->shop_name?>'
                }<?php if(count($shops) == $n){
                }else{?>,<?php }}?>]
            }],

        });
    });
</script>
<?php }?>
<script type="text/javascript">
    //***********************************************
    $("#export").click(function () {
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        var users_province = $("#users_province").val();

        var productcategorys_id = $("#productcategorys_id").val();
        var shop_select_id = [];
        $('#shop_select_id option:selected').each(function (i, selected) {
            shop_select_id[i] = $(selected).val();
        });
        //console.log(shop_select_id); return false;
        waitingDialog.show('<?php echo trans('messages.text_loading_lease_wait')?>', {
            progressType: 'success'
        });
        var key_token = $('input[name=_token]').val();
        $.ajax({
            headers: {'X-CSRF-TOKEN': key_token},
            type: "POST",
            url: "<?php echo url('admin/reports/salebyshop/export')?>",
            data: {
                start_date: start_date
                ,end_date: end_date
                ,users_province: users_province
                ,shop_select_id: shop_select_id
            },
            success: function (response) {
                $('.modal-content').empty();
                $('.modal-content').html('<div class="modal-body text-center"><button class="btn btn-info a-download" id="btn-download" style="margin-right: 5px;"><?php echo trans('messages.download')?></button><button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo trans('messages.btn_close')?></button></div>');
                $(".a-download").click(function () {
                    waitingDialog.hide();
                    window.open(
                        "<?php echo url('admin/reports/buy/download/?file=')?>" + response.file,
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
