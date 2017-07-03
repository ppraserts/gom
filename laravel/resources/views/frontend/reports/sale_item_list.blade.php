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

        <div class="row">
            <h2>รายงานยอดจำหน่ายสินค้า</h2>
        </div>
        <form action="{{url('user/reports/sale')}}" class="form-horizontal" id="my-form" method="GET">
            {{--{{csrf_field()}}--}}
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
                        {!! Form::text('start_date', '', array('placeholder' => trans('messages.text_start_date'),'class' => 'form-control', 'id'=>'start_date')) !!}
                        <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                    </div>
                </div>
                <div class="form-group col-md-6" style="padding-left: 0px; padding-right: 0;">
                    <strong style="padding-right: 0;padding-left: 0;">
                        * {{ trans('messages.text_end_date') }} :
                    </strong>
                    <div class='input-group date' id='pick_end_date'>
                        {!! Form::text('end_date', '', array('placeholder' => trans('messages.text_end_date'),'class' => 'form-control', 'id'=>'end_date')) !!}
                        <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                    </div>
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
                <div class="col-md-2" style="padding-left: 0px; padding-right: 0;">
                    <button class="btn btn-primary pull-left" type="submit">
                        <i class="fa fa-search"></i> {{ trans('messages.search') }}
                    </button>
                </div>
            </div>
        </form>

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
<link href="{{url('bootstrap-select/css/bootstrap-select.min.css')}}" type="text/css" rel="stylesheet">
<script src="{{url('bootstrap-select/js/bootstrap-select.min.js')}}"></script>
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
    })


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
                text: 'ยอดจำหน่ายสินค้ารวมทั้งหมด'
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
                data: [<?php $n = 1; foreach ($orderSaleItem as $val){ ?>{
                    name: '<?php echo $val->product_name_en?>',
                    y: <?php echo $val->total_amounts?>,
                    drilldown: '<?php echo $val->product_name_en?>'
                }<?php if(count($orderSaleItem) == $n){
                }else{?>,<?php }}?>]
            }],

        });
    });
</script>
<?php }?>
@endpush
