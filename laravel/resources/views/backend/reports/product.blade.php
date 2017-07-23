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
            <h2>{{ trans('messages.text_report_menu_product') }}</h2>

        </div>
        {{csrf_field()}}
        <form action="{{url('admin/reports/product')}}" class="form-horizontal" id="myForm" method="GET" data-toggle="validator" role="form">
            <input type="hidden" name="is_search" value="true">
            <div class="row">
                <div class="col-md-6 form-group {{ $errors->has('productcategorys_id') ? 'has-error' : '' }}"
                     style="padding-left: 0;">
                    <strong>
                        * {{ trans('validation.attributes.productcategorys_id') }}:
                    </strong>
                    <select id="productcategorys_id" name="productcategorys_id" class="form-control"
                            data-error={{trans('validation.attributes.message_validate_product_category')}}>
                        <option value="">{{ trans('messages.all') }}</option>
                        @foreach ($productCategoryitem as $key => $itemcategory)
                            <option value="{{ $itemcategory->id }}"
                                    @if(!empty($productcategory_id) && $itemcategory->id == $productcategory_id) selected @endif>
                                {{ $itemcategory->{ "productcategory_title_".Lang::locale()} }}
                            </option>
                        @endforeach
                    </select>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="col-md-6  form-group" style="padding-left: 0;padding-right: 0;">
                    <strong>
                        {{ trans('messages.menu_market') }} :
                    </strong>
                    <select class="form-control" name="market_id" id="market_id">
                        <option value="">
                            {{ trans('messages.all') }}
                        </option>
                        @if(!empty($markets) && count($markets) > 0)
                            @foreach($markets as $market)
                                <option value="{{$market->id}}"
                                        @if(!empty($market_id) and $market->id == $market_id) selected  @endif>
                                    {{$market->market_title_th}}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                {{--<div class="col-md-6  form-group {{ $errors->has('productcategorys_id') ? 'has-error' : '' }}"--}}
                     {{--style="padding-left: 0;padding-right: 0;">--}}
                    {{--<strong>--}}
                        {{--{{ trans('messages.menu_add_product') }} :--}}
                    {{--</strong>--}}
                    {{--<select class="selectpicker form-control" name="product_id[]" id="product"--}}
                            {{--data-live-search="true"--}}
                            {{--multiple>--}}
                        {{--@if(!empty($products) && count($products))--}}
                            {{--@foreach($products as $product)--}}
                                {{--<option value="{{$product->id}}"--}}
                                        {{--@if(!empty($product_id_arr)) @if(in_array($product->id, $product_id_arr)) selected @endif @endif>--}}
                                    {{--{{$product->product_name_th}}--}}
                                {{--</option>--}}
                            {{--@endforeach--}}
                        {{--@endif--}}
                    {{--</select>--}}
                {{--</div>--}}
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
                            <th>{{trans('messages.product_name')}}</th>
                            <th style="text-align:center;">{{trans('messages.menu_market')}}</th>
                            <th style="text-align:center;">{{trans('messages.text_product_score')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($results as $result)
                            <tr>
                                <td>{{$result->product_name_th}}</a>  </td>
                                <td>
                                    @foreach($result->markets as $market)
                                        <p>- {{$market->market_name}}</p>
                                    @endforeach
                                </td>
                                <td>
                                    @if(!empty($result->product_score)){{ (float)$result->product_score }} @else
                                        0 @endif
                                    {{ trans('messages.text_star') }}
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
        @if(count($results) > 0 && count($errors) < 1)
            <div class="row">
                <div class="col-md-6">{!! $results->appends(Request::all()) !!}</div>
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
        <input type="hidden" id="btn_close" value="{{trans('messages.btn_close')}}">
    </div>
@endsection

@push('scripts')
<link href="{{url('css/view-backend/reports.css')}}" type="text/css" rel="stylesheet">
<link href="{{url('bootstrap-select/css/bootstrap-select.min.css')}}" type="text/css" rel="stylesheet">
<script src="{{url('bootstrap-select/js/bootstrap-select.min.js')}}"></script>
<script src="{{url('jquery-plugin-for-bootstrap-loading-modal/build/bootstrap-waitingfor.js')}}"></script>
<script src="{{url('bootstrap-validator/js/validator.js')}}"></script>
<script type="text/javascript">
    /*$('#productcategorys_id').on('change', function () {
        var cateId = this.value;
        $.get("echo url('admin/reports/getproductbycate')" + '/' + cateId, function (data) {
            if (data.R == 'Y') {
                $("#product").html(data.res);
                $('#product').selectpicker('refresh');
            }
        });
    });*/

    //***********************************************
    $("#export").click(function () {
        var productcategorys_id = $('#productcategorys_id option:selected').val();
        var market_id = $('#market_id option:selected').val();
//        var product_id = [];
//        $('#product option:selected').each(function (i, selected) {
//            product_id[i] = $(selected).val();
//        });

        var key_token = $('input[name=_token]').val();
        waitingDialog.show('<?php echo trans('messages.text_loading_lease_wait')?>', {
            progressType: 'success'
        });
        $.ajax({
            headers: {'X-CSRF-TOKEN': key_token},
            type: "POST",
            url: "<?php echo url('admin/reports/product/export')?>",
            data: { market_id: market_id
                , productcategorys_id: productcategorys_id
            },
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
