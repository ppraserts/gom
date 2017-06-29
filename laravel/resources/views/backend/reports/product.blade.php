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
        <div class="row">
            <h4>{{ trans('messages.text_report_menu_product') }} :</h4>
            <form action="{{url('admin/reports/product')}}" class="form-horizontal" id="my-form" method="POST">
                {{csrf_field()}}
                <div class="form-group form-group-sm col-md-11" style="padding-left: 0px; padding-right: 0;">
                    <label class="col-sm-2 text-right" style="padding-right: 0; padding-left: 0;">
                        * {{ trans('messages.menu_add_product') }} :
                    </label>
                    <div class='col-sm-10' style="padding-right: 0;">
                        <select class="selectpicker form-control" name="product[]" id="product"
                                data-live-search="true"
                                multiple>
                            @if(count($productCategorys))
                                @foreach($productCategorys as $productCategory)
                                    <option value="{{$productCategory->id}}" @if(!empty($productArr)) @if(in_array($productCategory->id, $productArr)) selected @endif @endif>
                                        {{$productCategory->productcategory_title_th}}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <small class="alert-danger" id="ms_product"></small>
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
                        <th width="120px" style="text-align:center;">{{trans('messages.text_product_id')}}</th>
                        <th>{{trans('messages.text_product_th')}}</th>
                        <th style="text-align:center;">{{trans('messages.text_product_en')}}</th>
                        <th style="text-align:center;">{{trans('messages.text_product_score')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($results as $result)
                        <tr>
                            <td style="text-align:center;">{{ $result->id }}</td>
                            <td>{{$result->product_name_th}}</a>  </td>
                            <td>{{ $result->product_name_en }}</td>
                            <td>
                                @if(!empty($result->product_score)){{ number_format($result->product_score,2) }} @else 0 @endif
                                {{ trans('messages.text_star') }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
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
    </div>
@endsection

@push('scripts')
<link href="{{url('css/view-backend/reports.css')}}" type="text/css" rel="stylesheet">
<link href="{{url('bootstrap-select/css/bootstrap-select.min.css')}}" type="text/css" rel="stylesheet">
<script src="{{url('bootstrap-select/js/bootstrap-select.min.js')}}"></script>
<script type="text/javascript">
    $(function () {
        $('#my-form').submit(function () {
            var product = $("#product option:selected").val();
            if (!product) {
                $("#product").focus();
                $("#ms_product").html('<?php echo Lang::get('validation.attributes.message_validate_shop')?>');
                return false;
            } else {
                $("#ms_product").html('');
            }
        });
    });

    //***********************************************
    $("#export").click(function () {
        var product_cate_id = [];
        $('#product option:selected').each(function (i, selected) {
            product_cate_id[i] = $(selected).val();
        });
        var key_token = $('input[name=_token]').val();
        $.ajax({
            headers: {'X-CSRF-TOKEN': key_token},
            type: "POST",
            url: "<?php $page = ''; if (!empty(Request::input('page'))) {
                $page = '?page=' . Request::input('page');
            } echo url('admin/reports/product/export' . $page)?>",
            data: { product_arr: product_cate_id},
            success: function (response) {
                window.open(
                    "<?php echo url('admin/reports/shop/download/?file=')?>" + response.file,
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
