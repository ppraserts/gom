@extends('layouts.dashboard')
@section('page_heading',trans('messages.matching_report'))
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
        <div class="row">
            <h2>{{ trans('messages.matching_report') }}</h2>
            <form action="{{url('admin/reports/matching')}}" class="form-horizontal" id="my-form" method="GET">
                {{--{{csrf_field()}}--}}
                <input type="hidden" name="is_search" value="true"/>
                <style>
                    .form-horizontal .form-group {
                        margin-right: 0px;
                        margin-left: 0px;
                    }
                </style>
                <div class="form-group form-group-sm col-md-6" style="padding-left: 0px;">
                    <label class="col-sm-2"
                           style="padding-right: 0; padding-left: 0;">* {{ trans('messages.text_start_date') }}
                        :</label>
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
                    <label class="col-sm-2"
                           style="padding-right: 0;padding-left: 0;">* {{ trans('messages.text_end_date') }} :</label>
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

                <div class="form-group form-group-sm col-md-5" style="padding-left: 0px; padding-right: 0;">
                    <label class="col-sm-2"
                           style="padding-right: 0; padding-left: 0;">{{ trans('messages.text_product_type_name') }}
                        :</label>
                    <div class='col-sm-10' style="padding-right: 0;">
                        <select class="selectpicker form-control" name="product_type_name[]" id="product_type_name"
                                data-live-search="true"
                                multiple>
                            @if(count($products))
                                @foreach($products as $product)
                                    <option value="{{$product->id}}"
                                            @if(!empty($productTypeNameArr)) @if(in_array($product->id, $productTypeNameArr)) selected @endif @endif>
                                        {{$product->product_name_th}}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <small class="alert-danger" id="ms_product_type_name"></small>
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="form-group form-group-sm col-md-5" style="padding-left: 0px; padding-right: 0;">
                    <label class="col-sm-2"
                           style="padding-right: 0; padding-left: 0;">{{ trans('validation.attributes.product_province_selling') }}
                        :</label>
                    <div class='col-sm-10' style="padding-right: 0;">
                        <select class="selectpicker form-control" name="province_type_name[]" id="province_type_name"
                                data-live-search="true"
                                multiple>
                            @if(count($provinces))
                                @foreach($provinces as $province)
                                    <option value="{{$province->id}}"
                                            @if(!empty($provinceTypeNameArr)) @if(in_array($province->id, $provinceTypeNameArr)) selected @endif @endif>
                                        {{$province->PROVINCE_NAME}}
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
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th width="60px" style="text-align:center;">{{ trans('messages.no') }}</th>
                        <th style="text-align:center;">{{ trans('validation.attributes.product_title') }}</th>
                        <th style="text-align:center;">{{ trans('messages.text_product_type_name') }}</th>
                        <th>{{ trans('messages.i_sale') }}</th>
                        <th>{{ trans('messages.i_buy') }}</th>
                        <th style="text-align:center;">{{ trans('validation.attributes.price') }}</th>
                        {{--<th style="text-align:center;">{{ trans('messages.product_price_need_buy') }}</th>--}}
                        <th style="text-align:center;">{{ trans('validation.attributes.volumnrange_product_need_buy') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($matchings as $key => $item)
                        <tr>
                            <td style="text-align:center;">{{ $key+1 }}</td>
                            <td style="text-align:center;">{{ $item->product_title }}</td>
                            <td style="text-align:center;">{{ $item->product_name_th }}</td>
                            <td>{{ $item->seller_firstname. " ". $item->seller_lastname }}</td>
                            <td>{{ $item->buyer_firstname. " ". $item->buyer_lastname }}</td>
                            <td style="text-align:center;">{{ $item->price. " " . trans('messages.baht')." / ".$item->units }}</td>
                            {{--<td style="text-align:center;">{{ $item->pricerange_start . " - ". $item->pricerange_end . trans('messages.baht') }}</td>--}}
                            <td style="text-align:center;">{{ $item->volumnrange_start . " - ". $item->volumnrange_end ." ". $item->units }}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-6">{!! $matchings->appends(Request::all()) !!}</div>
                    <div class="col-md-6">
                        <div class="col-md-12" style="padding-left: 0; padding-right: 0; margin-top: 20px;">
                            <button class="btn btn-primary pull-right" id="export" type="button">
                                {{trans('messages.export_excel')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection

@push('scripts')
<link href="{{url('css/view-backend/reports.css')}}" type="text/css" rel="stylesheet">
<link href="{{url('bootstrap-select/css/bootstrap-select.min.css')}}" type="text/css" rel="stylesheet">
<script src="{{url('bootstrap-select/js/bootstrap-select.min.js')}}"></script>
<link href="http://gom.localhost/css/bootstrap-datepicker.standalone.min.css" rel="stylesheet">
<script src="http://gom.localhost/js/bootstrap-datepicker.min.js"></script>
<script src="http://gom.localhost/js/bootstrap-datepicker-thai.js"></script>
<script src="http://gom.localhost/js/bootstrap-datepicker.th.min.js"></script>

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

    //***********************************************
    $("#export").click(function () {
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        var filter = $("#filter").val();
        //var product_type_name = $("#product_type_name option:selected").val();
        var product_type_name = [];
        $('#product_type_name option:selected').each(function (i, selected) {
            product_type_name[i] = $(selected).val();
        });
        //console.log(product_type_name); return false;
        var key_token = $('input[name=_token]').val();
        $.ajax({
            headers: {'X-CSRF-TOKEN': key_token},
            type: "POST",
            url: "<?php $page = ''; if (!empty(Request::input('page'))) {
                $page = '?page=' . Request::input('page');
            } echo url('admin/reports/matching/export' . $page)?>",
            data: {start_date: start_date, end_date: end_date, product_type_name: product_type_name},
            success: function (response) {
                    console.log(response);
                window.open(
                    "<?php echo url('admin/reports/matching/download/?file=')?>" + response.file,
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
