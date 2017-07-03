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
            {{csrf_field()}}
            <form action="{{url('admin/reports/product')}}" class="form-horizontal" id="my-form" method="GET">
                <input type="hidden" name="is_search" value="true">
                <div class="col-md-6 {{ $errors->has('productcategorys_id') ? 'has-error' : '' }}"
                     style="padding-left: 0;">
                    <strong>
                        * {{ trans('validation.attributes.productcategorys_id') }}:
                    </strong>
                    <select id="productcategorys_id" name="productcategorys_id" class="form-control">
                        <option value="">{{ trans('messages.menu_product_category') }}</option>
                        @foreach ($productCategoryitem as $key => $itemcategory)
                            <option value="{{ $itemcategory->id }}" @if(!empty($productcategory_id) && $itemcategory->id == $productcategory_id) selected @endif>
                                {{ $itemcategory->{ "productcategory_title_".Lang::locale()} }}
                            </option>
                        @endforeach
                    </select>

                </div>
                <div class="col-md-6 {{ $errors->has('productcategorys_id') ? 'has-error' : '' }}"
                     style="padding-left: 0;">
                    <strong>
                         {{ trans('messages.menu_add_product') }} :
                    </strong>
                    <select class="selectpicker form-control" name="product_id[]" id="product"
                            data-live-search="true"
                            multiple>
                        @if(!empty($products) && count($products))
                            @foreach($products as $product)
                                <option value="{{$product->id}}"
                                        @if(!empty($product_id_arr)) @if(in_array($product->id, $product_id_arr)) selected @endif @endif>
                                    {{$product->product_name_th}}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-12" style="padding-left: 0; margin-top: 10px;">
                    <button class="btn btn-primary btn-sm" type="submit">
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
        <input type="hidden" id="btn_close" value="{{trans('messages.btn_close')}}">
    </div>
@endsection

@push('scripts')
<link href="{{url('css/view-backend/reports.css')}}" type="text/css" rel="stylesheet">
<link href="{{url('bootstrap-select/css/bootstrap-select.min.css')}}" type="text/css" rel="stylesheet">
<script src="{{url('bootstrap-select/js/bootstrap-select.min.js')}}"></script>
<script src="{{url('jquery-plugin-for-bootstrap-loading-modal/build/bootstrap-waitingfor.js')}}"></script>
<script type="text/javascript">
    $('#productcategorys_id').on('change', function() {
        var cateId = this.value;
        $.get("<?php echo url('admin/reports/getproductbycate')?>"+'/'+cateId, function(data){
            if(data.R == 'Y'){
                $("#product" ).html(data.res);
                $('#product').selectpicker('refresh');
            }
        });
    });

    //***********************************************
    $("#export").click(function () {
        var productcategorys_id = $('#productcategorys_id option:selected').val();
        var product_id = [];
        $('#product option:selected').each(function (i, selected) {
            product_id[i] = $(selected).val();
        });
        var key_token = $('input[name=_token]').val();
        waitingDialog.show('<?php echo trans('messages.text_loading_lease_wait')?>', {
            progressType: 'success'
        });
        $.ajax({
            headers: {'X-CSRF-TOKEN': key_token},
            type: "POST",
            url: "<?php echo url('admin/reports/product/export')?>",
            data: { product_id_arr: product_id, productcategorys_id: productcategorys_id},
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
