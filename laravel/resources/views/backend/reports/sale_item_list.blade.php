<?php
//$pagetitle = trans('messages.menu_order_list');
?>
@extends('layouts.dashboard')
@section('page_heading','รายงานยอดจำหน่ายสินค้า')
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
            <h2>รายงานยอดจำหน่ายสินค้า</h2>
            <form action="{{url('admin/reports/sale')}}" class="form-horizontal" id="my-form" method="GET">
                {{--{{csrf_field()}}--}}
                <input type="hidden" name="is_search" value="true"/>
                <style>
                    .form-horizontal .form-group {
                        margin-right: 0px;
                        margin-left: 0px;
                    }
                </style>
                <div class="form-group form-group-sm col-md-6" style="padding-left: 0px;">
                    <label class="col-sm-2" style="padding-right: 0; padding-left: 0;">* {{ trans('messages.text_start_date') }} :</label>
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
                    <label class="col-sm-2" style="padding-right: 0;padding-left: 0;">* {{ trans('messages.text_end_date') }} :</label>
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
                    <label class="col-sm-1" style="padding-right: 0; padding-left: 0;">{{ trans('messages.text_product_type_name') }} :</label>
                    <div class='col-sm-11' style="padding-right: 0;">
                        <select class="selectpicker form-control" name="product_type_name[]" id="product_type_name" data-live-search="true"
                                multiple>
                            @if(count($products))
                                @foreach($products as $product)
                                    <option value="{{$product->id}}" @if(!empty($productTypeNameArr)) @if(in_array($product->id, $productTypeNameArr)) selected @endif @endif>
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
            @if(count($orderSaleItem) > 0)
            <div id="container" style="min-width: 400px; height: 520px; margin: 0px auto; padding-top:2%;"></div>
            @else
                <div style="margin: 0px auto; padding-top:2%;">
                    Data not found
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
<script src="{{url('jquery-plugin-for-bootstrap-loading-modal/build/bootstrap-waitingfor.js')}}"></script>
<script src="{{ url('charts/js/highcharts.js')}}"></script>
<script src="{{ url('charts/js/modules/exporting.js')}}"></script>
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
<?php if(count($orderSaleItem) > 0){ ?>
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
                type: 'column'
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
                        rotation: -90,
                        color: '#FFFFFF',
                        align: 'center',
                        format: '{point.y:.1f} บาท',
                        y: 35,
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
                data: [<?php $n=1; foreach ($orderSaleItem as $val){ ?>{
                    name: '<?php echo $val->product_name_en?>',
                    y: <?php echo $val->total_amounts?>,
                    drilldown: '<?php echo $val->product_name_en?>'
                }<?php if(count($orderSaleItem) == $n){ }else{?>,<?php }}?>]
            }],

        });
    });
</script>
<?php }?>
@endpush
