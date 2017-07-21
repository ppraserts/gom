<?php
$pagetitle = trans('message.menu_order_list');
?>
@extends('layouts.main')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="glyphicon glyphicon-apple"></i>')
@section('content')
    @include('shared.usermenu', array('setActive'=>'sale'))
    <div class="col-sm-12" style="padding: 10px 25px; border: 1px solid #ddd; margin-top: 15px;">
        <div class="row">
            @include('frontend.reports.menu_reports')
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
            <h2>{{trans('messages.report_title_sale')}}</h2>
        </div>
        {{csrf_field()}}
        <form action="{{url('user/reports/sale')}}" class="form-horizontal" id="myForm" method="GET" data-toggle="validator" role="form">
            <input type="hidden" name="is_search" value="true"/>
            <style>
                .form-horizontal .form-group {
                    margin-right: 0px;
                    margin-left: 0px;
                }
            </style>
            <div class="row">
                <div class="form-group col-md-6" style="padding-left: 0px;">
                    <strong style="padding-right: 0; padding-left: 0;">*
                        {{ trans('messages.text_start_date') }}:
                    </strong>
                    <div class='input-group date' id='pick_start_date'>
                        {!! Form::text('start_date', '', array('placeholder' => trans('messages.text_start_date'),'class' => 'form-control', 'id'=>'start_date','data-error'=>trans('validation.attributes.message_validate_start_date'),'required'=>'required')) !!}
                        <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                    </div>
                    <div class="help-block with-errors"></div>
                    <span id="with_errors_start_date"> </span>
                </div>
                <div class="form-group col-md-6" style="padding-left: 0px; padding-right: 0;">
                    <strong style="padding-right: 0;padding-left: 0;">
                        * {{ trans('messages.text_end_date') }} :
                    </strong>
                    <div class='input-group date' id='pick_end_date'>
                        {!! Form::text('end_date', '', array('placeholder' => trans('messages.text_end_date'),'class' => 'form-control', 'id'=>'end_date','data-error'=>trans('validation.attributes.message_validate_end_date'),'required'=>'required')) !!}
                        <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                    </div>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 {{ $errors->has('productcategorys_id') ? 'has-error' : '' }}"
                     style="padding-left: 0;">
                    <strong>
                        {{ trans('validation.attributes.productcategorys_id') }}:
                    </strong>
                    <select id="productcategorys_id" name="productcategorys_id" class="form-control">
                        <option value="">{{ trans('messages.menu_product_category') }}</option>
                        @foreach ($productCategoryitem as $key => $itemcategory)
                            <option value="{{ $itemcategory->id }}"
                                    @if(!empty($productcategorys_id) && $itemcategory->id == $productcategorys_id))
                                    selected @endif>
                                {{ $itemcategory->{ "productcategory_title_".Lang::locale()} }}

                            </option>
                        @endforeach
                    </select>

                </div>


                <div class="form-group col-md-6" style="padding-left: 0px; padding-right: 0;">
                    <strong style="padding-right: 0; padding-left: 0;">
                        {{ trans('messages.text_product_type_name') }} :
                    </strong>
                    <select class="selectpicker form-control" name="pid[]" id="product_type_name"
                            data-live-search="true"
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
                <div class="text-center" style="padding-left: 0px; padding-right: 0;">
                    <button style="width: 400px;" class="btn btn-primary" type="submit">
                        <i class="fa fa-search"></i> {{ trans('messages.search') }}
                    </button>
                </div>
            </div>
        </form>

        <div class="row" style="margin-top: 10px">
            @if(count($orderSaleItem) > 0 && count($errors) < 1)
                <div id="container" style="min-width: 400px; height: auto; margin: 0px auto; padding-top:2%;"></div>
            @else
                <div class="alert alert-warning text-center">
                    <strong>{{trans('messages.data_not_found')}}</strong>
                </div>
            @endif

        </div>
    </div>
@endsection
@push('scripts')
<link href="{{url('bootstrap-select/css/bootstrap-select.min.css')}}" type="text/css" rel="stylesheet">
<script src="{{url('bootstrap-select/js/bootstrap-select.min.js')}}"></script>
<script src="{{url('bootstrap-validator/js/validator.js')}}"></script>
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

    $('#productcategorys_id').on('change', function() {
        var cateId = this.value;
        $.get("<?php echo url('admin/reports/getproductbycate')?>"+'/'+cateId, function(data){
            if(data.R == 'Y'){
                console.log(data.res);
                $("#product_type_name" ).html(data.res);
                $('#product_type_name').selectpicker('refresh');
            }
        });
    });

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
                type: 'bar'
            },
            title: {
                text: '{{trans('messages.all_sale_total')}}'
            },
            subtitle: {
                text: '<span style="color:#353535; font-weight:bold; font-size:14px; ">{{trans('messages.total_order')}} : {{ number_format($sumAll)}} {{trans('messages.baht')}} </span>'
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: '{{trans('messages.sale_total')}}'
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
                        format: '{point.y:.1f} {{trans('messages.baht')}}',
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
                pointFormat: '<span style="color:{point.color}">{point.name}</span> : <b>{point.y:.2f} {{trans('messages.baht')}}</b><br/>'
            },

            series: [{
                name: '',
                colorByPoint: true,
                data: [<?php $n = 1; foreach ($orderSaleItem as $val){ ?>{
                    name: '<?php echo $val->product_name_th?>',
                    y: <?php echo $val->total_amounts?>,
                    drilldown: '<?php echo $val->product_name_th?>'
                }<?php if(count($orderSaleItem) == $n){
                }else{?>,<?php }}?>]
            }],

        });
    });
</script>
<?php }?>
@endpush
