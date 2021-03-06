<?php
//$pagetitle = trans('messages.menu_order_list');
?>
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
            <h2>{{ trans('messages.report_title_sale') }}</h2>
        </div>
        {{csrf_field()}}
        <form action="{{url('admin/reports/sale')}}" class="form-horizontal" id="myForm" method="GET" data-toggle="validator" role="form">
            <input type="hidden" name="is_search" value="true"/>
            <style>
                .form-horizontal .form-group {
                    margin-right: 0px;
                    margin-left: 0px;
                }
            </style>
            <div class="row">
                <div class="form-group col-md-4" style="padding-left: 0px;">
                    <strong style="padding-right: 0; padding-left: 0;">*
                        {{ trans('messages.text_start_date') }} :
                    </strong>
                    <div class='input-group date' id='pick_start_date'>
                        {!! Form::text('start_date', $defult_ymd_last_month, array('placeholder' => trans('messages.text_start_date'),'class' => 'form-control', 'id'=>'start_date','data-error'=>trans('validation.attributes.message_validate_start_date'),'required'=>'required')) !!}
                        <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                    </div>
                    <div class="help-block with-errors"></div>
                    <span id="with_errors_start_date"> </span>
                </div>
                <div class="form-group col-md-4" style="padding-left: 0px;">
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
                <div class="form-group col-md-4" style="padding-left: 0px; padding-right: 0;">
                    <strong style="padding-right: 0;padding-left: 0;">
                        {{trans('messages.order_type_sale')}} :
                    </strong>
                    <select id="selling_type" name="selling_type" class="form-control">
                        <option value="">{{ trans('messages.all') }}</option>
                        <?php
                        $r_selected = "";
                        $w_selected = "";
                        if(!empty(Request::input('selling_type'))){
                            if(Request::input('selling_type') == 'retail'){
                                $r_selected = "selected";
                            }
                            if(Request::input('selling_type') == 'wholesale'){
                                $w_selected = "selected";
                            }
                        }
                        ?>
                        <option value="retail" {{$r_selected}}>
                            {{trans('messages.retail')}}
                        </option>
                        <option value="wholesale" {{$w_selected}}>
                            {{trans('messages.wholesale')}}
                        </option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4"  style="padding-left: 0;">
                    <strong>
                        {{ trans('messages.menu_market') }} :
                    </strong>
                    <select id="market_id" name="market_id" class="form-control">
                        <option value="">{{ trans('messages.all') }}</option>
                        @foreach ($markets as $market)
                            <option value="{{ $market->id }}" @if(!empty($market_id) && $market->id == $market_id)) selected @endif>
                                {{ $market->market_title_th }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 {{ $errors->has('productcategorys_id') ? 'has-error' : '' }}"
                     style="padding-left: 0;">
                    <strong>
                        {{ trans('validation.attributes.productcategorys_id') }}:
                    </strong>
                    <select id="productcategorys_id" name="productcategorys_id" class="form-control">
                        <option value="">{{ trans('messages.all') }}</option>
                        @foreach ($productCategoryitem as $key => $itemcategory)
                            <option value="{{ $itemcategory->id }}" @if(!empty($productcategorys_id) && $itemcategory->id == $productcategorys_id)) selected @endif>
                                {{ $itemcategory->{ "productcategory_title_".Lang::locale()} }}

                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4" style="padding-left: 0px; padding-right: 0;">
                    <strong style="padding-right: 0; padding-left: 0;">
                        {{ trans('messages.text_product_type_name') }} :
                    </strong>
                    <select class="selectpicker form-control" name="pid[]" id="product_type_name"  data-live-search="true" title=" "
                            multiple>
                        @if(!empty($products) && count($products))
                            @foreach($products as $product)
                                <option value="{{$product->id}}"
                                        @if(!empty($productTypeNameArr)) @if(in_array($product->id, $productTypeNameArr)) selected @endif @endif>
                                    {{$product->product_name_th}}
                                </option>
                            @endforeach
                        @endif
                    </select>
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
            @include('backend.reports.ele_sale_item_report_charts')
        @elseif(Request::input('format_report') == 2)
            @include('backend.reports.ele_sale_item_report_table')
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
<script src="{{ url('charts/js/highcharts.js')}}"></script>
<script src="{{ url('charts/js/modules/exporting.js')}}"></script>
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

        $('#productcategorys_id').on('change', function() {
            var cateId = this.value;
            $.get("<?php echo url('admin/reports/getproductbycate')?>"+'/'+cateId, function(data){
                if(data.R == 'Y'){
                    console.log(data.res);
                    $("#product_type_name" ).html(data.res);
                    $('#product_type_name').selectpicker('refresh');
                }
            });
        })
    });

</script>
<?php if(count($orderSaleItem) > 0){ ?>
<?php if(Request::input('format_report') == 1 or empty(Request::input('format_report'))){ ?>
<script src="{{ url('charts/js/highcharts.js')}}"></script>
<script src="{{ url('charts/js/modules/exporting.js')}}"></script>
<style type="text/css">
    ${
demo.css
}
</style>
<script type="text/javascript">

    $(function () {
        $('#container').highcharts({
            chart: {
//                type: 'column'
                type: 'bar'
            },
            title: {
                text: 'ยอดจำหน่ายสินค้า {{(isset($start_date) && isset($end_date)) ? ('วันที่ '. \App\Helpers\DateFuncs::mysqlToThaiDateString($start_date) . ' ถึง '.\App\Helpers\DateFuncs::mysqlToThaiDateString($end_date)) : ""}}'
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
                        y: 0,
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
                data: [<?php $n = 1; foreach ($orderSaleItem as $val){ ?>{
                    name: '<?php echo $val->product_name_th?>',
                    y: <?php echo $val->total?>,
                    drilldown: '<?php echo $val->product_name_th?>'
                }<?php if(count($orderSaleItem) == $n){
                }else{?>,<?php }}?>]
            }],

        });
    });
</script>
<?php } }?>

@endpush
