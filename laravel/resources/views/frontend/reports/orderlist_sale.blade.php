<?php
$pagetitle = trans('message.menu_order_list');
?>
@extends('layouts.main')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="glyphicon glyphicon-apple"></i>')
@section('content')
    @include('shared.usermenu', array('setActive'=>'reports'))
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
            <h2>{{ trans('messages.menu_shop_order_list') }}</h2>
        </div>
        <form action="{{url('user/reports/buy')}}" class="form-horizontal" id="myForm" method="GET" data-toggle="validator" role="form">
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
            @if(count($orderLists) > 0 && count($errors) <1)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <th width="120px" style="text-align:center;">{{ trans('messages.order_id') }}</th>
                            <th style="text-align:center;">{{ trans('messages.order_type') }}</th>
                            <th>{{ trans('messages.i_sale') }}</th>
                            <th>{{ trans('messages.i_buy') }}</th>
                            <th style="text-align:center;">{{ trans('messages.order_sale_date') }}</th>
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
                                <td>
                                    @if($item->order_type== 'retail')
                                        {{trans('messages.retail')}}
                                    @else
                                        {{trans('messages.wholesale')}}
                                    @endif
                                </td>
                                <td>{{ $item->users_firstname_th. " ". $item->users_lastname_th }}</td>
                                <th style="font-weight: normal">
                                    {{ $item->buyer->users_firstname_th. " ". $item->buyer->users_lastname_th }}
                                </th>
                                <td style="text-align:center;">{{ \App\Helpers\DateFuncs::mysqlToThaiDate($item->order_date) }}</td>
                                <td style="text-align:center;">{{ $item->total_amount . trans('messages.baht') }}</td>
                                <td style="text-align:center;">{{ $item->status_name }}</td>
                                <td style="text-align:center;">
                                    <a class="btn btn-primary"
                                       href="{{ url ('user/orderdetail/'.$item->id) }}">
                                        <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            @else
                <div class="alert alert-warning text-center">
                    <strong>{{trans('messages.data_not_found')}}</strong>
                </div>
            @endif
        </div>

        @if(count($orderLists) > 0 && count($errors) <1)
            <div class="row">
                <div class="col-md-6">{!! $orderLists->appends(Request::all()) !!}</div>
                <div class="col-md-6">
                    <div class="col-md-12" style="padding-left: 0; padding-right: 0; margin-top: 20px;">
                        <button class="btn btn-primary pull-right" id="export" type="button">
                            <span class="glyphicon glyphicon-export"></span>
                            {{ trans('messages.export_excel') }}
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <input type="hidden" id="btn_close" value="{{trans('messages.btn_close')}}">
    </div>
@endsection

@push('scripts')
<link href="{{url('bootstrap-select/css/bootstrap-select.min.css')}}" type="text/css" rel="stylesheet">
<script src="{{url('bootstrap-select/js/bootstrap-select.min.js')}}"></script>
<script src="{{url('jquery-plugin-for-bootstrap-loading-modal/build/bootstrap-waitingfor.js')}}"></script>
<script src="{{url('bootstrap-validator/js/validator.js')}}"></script>
<script type="text/javascript">
    $(function () {
        $('#myForm').submit(function () {
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();
            if (start_date != '') {
                if (start_date >= end_date) {
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

    $('#productcategorys_id').on('change', function () {
        var cateId = this.value;
        $.get("<?php echo url('admin/reports/getproductbycate')?>" + '/' + cateId, function (data) {
            if (data.R == 'Y') {
                console.log(data.res);
                $("#product_type_name").html(data.res);
                $('#product_type_name').selectpicker('refresh');
            }
        });
    });
    //***********************************************
    $("#export").click(function () {
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        //var product_type_name = $("#product_type_name option:selected").val();
        var product_type_name = [];
        $('#product_type_name option:selected').each(function (i, selected) {
            product_type_name[i] = $(selected).val();
        });
        waitingDialog.show('<?php echo trans('messages.text_loading_lease_wait')?>', {
            progressType: 'success'
        });
        var productcategorys_id =$('#productcategorys_id option:selected').val();
        var key_token = $('input[name=_token]').val();
        var type = 'sale';
        $.ajax({
            headers: {'X-CSRF-TOKEN': key_token},
            type: "POST",
            url: "<?php $page = ''; if (!empty(Request::input('page'))) {
                $page = '?page=' . Request::input('page');
            } echo url('user/reports/buy/export' . $page)?>",
            data: {start_date: start_date, end_date: end_date, product_type_name: product_type_name,type:type,productcategorys_id:productcategorys_id},
            success: function (response) {
                $('.modal-content').empty();
                $('.modal-content').html('<div class="modal-body text-center"><button class="btn btn-info a-download" id="btn-download" style="margin-right: 5px;"><?php echo trans('messages.download')?></button><button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo trans('messages.btn_close')?></button></div>');
                $(".a-download").click(function () {
                    waitingDialog.hide();
                    window.open(
                        "<?php echo url('user/reports/buy/download/?file=')?>" + response.file,
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
