@extends('layouts.main')
@push('scripts')
<script src="{{ asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
<script>
    CKEDITOR.replace('product_description');

    $('#btnDelete').on('click', function (e) {
        if (confirm('{{ trans('messages.confirm_delete', ['attribute' => $item->product_title]) }}')) {
            $.get('{{ url('user/information') }}/removeproduct/ajax-state?stateid={{ $item->id }}', function (data) {
                window.location.href = "{{ url('user/iwanttobuy') }}";
            });
        }
    });

    $('#province').on('change', function (e) {
        console.log(e);
        var state_id = e.target.value;

        $.get('{{ url('information') }}/create/ajax-state?province_id=' + state_id, function (data) {
            console.log(data);
            var option = '';
            $('#city').empty();

            //option += '<option value="">{{ Lang::get('validation.attributes.products_id') }}</option>';
            $.each(data, function (index, subCatObj) {
                option += '<option value="' + subCatObj.AMPHUR_NAME + '">' + subCatObj.AMPHUR_NAME + '</option>';
            });
            $('#city').append(option);
            $("#city").val('{{ $item->city==""? old('city'):$item->city}}');
            $("#city").trigger("change");
        });
    });

    setTimeout(function () {
        console.log('show productcategorys_id');
        var itemcategory = '{{ $item->id==0? old('productcategorys_id') : $item->productcategorys_id }}';
        if (itemcategory != "")
            $("#productcategorys_id").val({{ $item->id==0? old('productcategorys_id') : $item->productcategorys_id }}).change();

        var itemprovince = '{{ $item->province==""? old('province') : $item->province }}';
        if (itemprovince != "")
            $("#province").val('{{ $item->province==""? old('province') : $item->province }}').change();
    }, 500);

    var products_array = [];

    function validate() {
        if (jQuery.inArray($('input[name=fake_products_id]').val(), products_array) == -1) {
            alert('กรุณาระบุ สินค้าจากรายการเท่านั้น หากไม่พบข้อมูลโปรดติดต่อเจ้าหน้าที่');
            $('input[name=fake_products_id]').focus();
            return false;
        }
        return true;
    }

    $(function () {
        var query_url = '';
        var products;

        query_url = '/information/create/ajax-state';

        products = new Bloodhound({
            datumTokenizer: function (datum) {
                alert(datum);
                return Bloodhound.tokenizers.obj.whitespace(datum.id);
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: query_url + '?search=true&product_name_th=%QUERY',
                filter: function (products) {
                    // Map the remote source JSON array to a JavaScript object array
                    return $.map(products, function (product) {
                        return {
                            id: product.id,
                            value: product.product_name_th
                        };
                    });
                },
                wildcard: "%QUERY"
            }
        });

        products.initialize();

        $('.typeahead').typeahead({
            hint: false,
            highlight: true,
            minLength: 1,
            autoSelect: true
        }, {
            limit: 60,
            name: 'product_id',
            displayKey: 'value',
            source: products.ttAdapter(),
            templates: {
                header: '<div style="text-align: center;">ชื่อสินค้า</div><hr style="margin:3px; padding:0;" />'
            }
        });

        $('#productcategorys_id').on('change', function (e) {
            product_category_value = e.target.value;

            query_url = '/information/create/ajax-state?search=true&productcategorys_id=' + product_category_value;

            products = new Bloodhound({
                datumTokenizer: function (datum) {
                    alert(datum);
                    return Bloodhound.tokenizers.obj.whitespace(datum.id);
                },
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: query_url + '&product_name_th=%QUERY',
                    filter: function (products) {

                        products_array = [];
                        // Map the remote source JSON array to a JavaScript object array
                        return $.map(products, function (product) {

                            products_array[product.id] = product.product_name_th;

                            return {
                                id: product.id,
                                value: product.product_name_th
                            };
                        });
                    },
                    wildcard: "%QUERY"
                }
            });

            products.initialize();

            $('.typeahead').typeahead('destroy');
            $('.typeahead').typeahead({
                hint: false,
                highlight: true,
                minLength: 1,
                autoSelect: true
            }, {
                limit: 60,
                name: 'product_id',
                displayKey: 'value',
                source: products.ttAdapter(),
                templates: {
                    header: '<div style="text-align: center;">ชื่อสินค้า</div><hr style="margin:3px; padding:0;" />'
                }
            });
        });


        $('.typeahead').bind('typeahead:select', function (ev, suggestion) {
            $('#products_id').val(suggestion.id);
        });


        hideSuccessMessage();

    });

    function hideSuccessMessage() {
        setTimeout(function () {
            $('.alert-success').hide();
        }, 2000);

    }
</script>
@endpush
@section('content')
    @include('shared.usermenu', array('setActive'=>'iwanttobuy'))
    <br/>
    <form enctype="multipart/form-data" class="form-inline" role="form" method="post"
          action="{{ url('user/productbuyedit/'.$item->id) }}">
        {{ csrf_field() }}
        {{ Form::hidden('product1_file_temp', $item->product1_file) }}
        {{ Form::hidden('product2_file_temp', $item->product2_file) }}
        {{ Form::hidden('product3_file_temp', $item->product3_file) }}
        {{ Form::hidden('users_id', $useritem->id) }}
        {{ Form::hidden('iwantto', $useritem->iwantto) }}
        <input name="_method" type="hidden" value="PATCH">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>{{ trans('messages.message_whoops_error')}}</strong> {{ trans('messages.message_result_error')}}
                <br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        {{--Button--}}
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                </div>
                <div class="pull-right">
                    <button type="submit" class="btn btn-primary" onclick="return validate();">
                        <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                        {{ trans('messages.button_save')}}
                    </button>
                    @if($item->id != 0)
                        <button id="btnDelete" type="button" class="btn btn-danger">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            {{ trans('messages.button_delete')}}
                        </button>
                    @endif
                </div>
            </div>
        </div>

        {{--<div class="row">--}}
        {{--<div class="col-xs-6 col-sm-6 col-md-6 ">--}}
        {{--<div class="form-group" style="margin-top: 20px">--}}
        {{--<label class="control-label"><strong>รูปแบบการขาย :</strong></label>--}}
        {{--<input type="radio" name="selling_type"  value="retail" checked {{ $item->selling_type == 'retail'? 'checked="checked"' : '' }}> ขายปลีก--}}
        {{--<input type="radio" name="selling_type" value="wholesale" {{ $item->selling_type == 'wholesale'? 'checked="checked"' : '' }}> ชายส่ง--}}
        {{--<input type="radio" name="selling_type" value="all" {{ $item->selling_type == 'all'? 'checked="checked"' : '' }}> ทั้งคู่--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="col-xs-6 col-sm-6 col-md-6 ">--}}
        {{--</div>--}}
        {{--<span class="clearfix"></span>--}}
        {{--</div>--}}
        <div class="panel panel-default" style="margin-top: 20px;">
            <div class="panel-heading">
                <strong>{{ trans('messages.product_info') }}</strong>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        {{--* กลุ่มสินค้า :--}}
                        <div class="form-group col-md-6 {{ $errors->has('productcategorys_id') ? 'has-error' : '' }}">
                            <strong>* {{ Lang::get('validation.attributes.productcategorys_id') }} :</strong>
                            <select id="productcategorys_id" name="productcategorys_id"
                                    class="form-control min-width-100pc">
                                <option value="">{{ trans('messages.menu_product_category') }}</option>
                                @foreach ($productCategoryitem as $key => $itemcategory)
                                    @if($item->productcategorys_id == $itemcategory->id)
                                        <option selected value="{{ $itemcategory->id }}">
                                            {{ $itemcategory->{ "productcategory_title_".Lang::locale()} }}
                                        </option>
                                    @else
                                        <option value="{{ $itemcategory->id }}">
                                            {{ $itemcategory->{ "productcategory_title_".Lang::locale()} }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group  col-md-6 {{ $errors->has('product_title') ? 'has-error' : '' }}">
                            <strong> {{ trans('validation.attributes.products_id') }}
                                :</strong>
                            {!! Form::text('fake_products_id', $product_name->product_name_th, array('placeholder' => trans('validation.attributes.products_id'),'class' => 'form-control min-width-100pc typeahead')) !!}
                            <input type="hidden" id="products_id" name="products_id" value="{{ $item->products_id }}">
                        </div>


                        @if(isset($standards))
                            <div class="form-group col-md-6 pd-top-10">
                                <strong style="display: block; padding-bottom: 5px;"> {{ trans('validation.attributes.guarantee') }}
                                    :</strong>
                                @for($i = 0 ; $i < count($standards) ; $i++)
                                    <label class="checkbox-inline">
                                        <input name="product_standard[]" type="checkbox"
                                               value="{{ $standards[$i]->id}}" {{ $standards[$i]->checked ? "checked" : ""}}>
                                        {{$standards[$i]->name}}
                                    </label>
                                @endfor
                            </div>
                            <div class="form-group col-md-6 pd-top-10">
                                <strong> {{ trans('messages.text_specify') }} :</strong>
                                {!! Form::text('product_other_standard', $item->product_other_standard, array('class' => 'form-control min-width-100pc')) !!}
                            </div>
                        @endif

                        <div id="div_packing_size"
                             class="form-group col-md-6 pd-top-10 {{ $errors->has('packing_size') ? 'has-error' : '' }}">
                            <strong> {{ trans('validation.attributes.product_package_size') }} :</strong>
                            {!! Form::number('packing_size', $item->packing_size, array('placeholder' => trans('validation.attributes.product_package_size'),'class' => 'form-control min-width-100pc')) !!}
                        </div>

                        <div class="form-group pd-top-10 col-md-3 {{ $errors->has('units') ? 'has-error' : '' }}">
                            <strong> {{ Lang::get('validation.attributes.units') }}
                                :</strong>
                            <select id="units" name="units" class="form-control min-width-100pc">
                                <option value="">{{ Lang::get('validation.attributes.units') }}</option>
                                @foreach ($unitsItem as $key => $unit)
                                    @if($item->units == $unit->{ "units_".Lang::locale()})
                                        <option selected
                                                value="{{ $unit->{ "units_".Lang::locale()} }}">{{ $unit->{ "units_".Lang::locale()} }}</option>
                                    @else
                                        <option value="{{ $unit->{ "units_".Lang::locale()} }}">{{ $unit->{ "units_".Lang::locale()} }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group pd-top-10 col-md-3 {{ $errors->has('grade') ? 'has-error' : '' }}">
                            <strong> {{ trans('messages.text_grade') }} :</strong>
                            <select id="grade" name="grade" class="form-control min-width-100pc">
                                @foreach ($grades as $key => $value)
                                    <option>{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <br/>
                        <div class="form-group pd-top-10 col-md-6 {{ $errors->has('pricerange_start')||$errors->has('pricerange_end') ? 'has-error' : '' }}">
                            <strong>* {{ Lang::get('validation.attributes.pricerange_start') }} (บาท):</strong>
                            {!! Form::text('pricerange_start', $item->pricerange_start, array('placeholder' => Lang::get('validation.attributes.pricerange_start'),'class' => 'form-control min-width-100pc')) !!}
                        </div>
                        <div class="form-group pd-top-10  col-md-6 {{ $errors->has('pricerange_start')||$errors->has('pricerange_end') ? 'has-error' : '' }}">
                            <strong>* {{ Lang::get('validation.attributes.pricerange_end') }} (บาท):</strong>
                            {!! Form::text('pricerange_end', $item->pricerange_end, array('placeholder' => Lang::get('validation.attributes.pricerange_end'),'class' => 'form-control min-width-100pc')) !!}
                        </div>
                        <br/>
                        <div class="form-group pd-top-10 col-md-6 {{ $errors->has('volumnrange_start')||$errors->has('volumnrange_end') ? 'has-error' : '' }}">
                            <strong>* {{Lang::get('validation.attributes.volumnrange_product_need')}} :</strong>
                            {!! Form::text('volumnrange_start', $item->volumnrange_start, array('placeholder' => Lang::get('validation.attributes.volumnrange_product_need'),'class' => 'form-control min-width-100pc')) !!}
                        </div>

                        <div class="form-group pd-top-10 col-md-6 {{ $errors->has('province') ? 'has-error' : '' }}">
                            <strong> {{ trans('messages.text_product_province') }}:</strong>
                            <select id="province" name="province" class="form-control min-width-100pc">
                                <option value="">{{ trans('messages.allprovince') }}</option>
                                @foreach ($provinceItem as $key => $province)
                                    @if($item->province == $province->PROVINCE_NAME)
                                        <option selected
                                                value="{{ $province->PROVINCE_NAME }}">{{ $province->PROVINCE_NAME }}</option>
                                    @else
                                        <option value="{{ $province->PROVINCE_NAME }}">{{ $province->PROVINCE_NAME }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .pd-top-10 {
                padding-top: 10px;
            }

            .min-width-100pc {
                width: 100% !important;
            }
        </style>
        <div class="panel panel-default" style="margin-top: 20px;">
            <div class="panel-heading">
                <strong>{{ trans('validation.attributes.product_description') }}</strong>
            </div>
            <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            {!! Form::textarea('product_description', $item->product_description, array('placeholder' => Lang::get('validation.attributes.product_description'),'class' => 'form-control')) !!}
                        </div>
                    </div>
            </div>
        </div>

    </form>
@stop
