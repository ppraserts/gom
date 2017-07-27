@extends('layouts.main')
@push('scripts')
<script src="{{url('bootstrap-validator/js/validator.js')}}"></script>
<script>
    $('#btnDelete').on('click', function (e) {
        if (confirm('{{ trans('messages.confirm_delete', ['attribute' => $item->product_title]) }}')) {
            $.get('{{ url('user/information') }}/removeproduct/ajax-state?stateid={{ $item->id }}', function (data) {
                window.location.href = "{{ url('user/iwanttobuy') }}";
            });
        }
    });
    ;

    setTimeout(function () {
        console.log('show productcategorys_id');
        var itemcategory = '{{ $item->id==0? old('productcategorys_id') : $item->productcategorys_id }}';
        if (itemcategory != "")
            $("#productcategorys_id").val({{ $item->id==0? old('productcategorys_id') : $item->productcategorys_id }}).change();

        var itemprovince = '{{ $item->province_selling==""? old('province_selling') : $item->province }}';
        //if (itemprovince != "")
        /*    $("#province").val('{{ $item->province_selling==""? old('province_selling') : $item->province }}').change();*/
    }, 500);

    var products_array = [];


    $(function () {
        var query_url = '';
        var products;

        query_url = '{{url('/information/create/ajax-state')}}';

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
                header: '<div style="text-align: center;">{{trans('messages.product_name')}}</div><hr style="margin:3px; padding:0;" />'
            }
        });

        $('#productcategorys_id').on('change', function (e) {
            product_category_value = e.target.value;

            query_url = '{{url('/information/create/ajax-state?search=true&productcategorys_id=')}}' + product_category_value;

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
                    header: '<div style="text-align: center;">{{trans('messages.product_name')}}</div><hr style="margin:3px; padding:0;" />'
                }
            });
        });
        $('.typeahead').bind('typeahead:select', function (ev, suggestion) {
            $('#products_id').val(suggestion.id);
        });
        hideSuccessMessage();

        $('input[type=radio][name=is_packing]').change(function () {
            if (this.value == '0') {
                $('#div_packing_size').show();
            } else if (this.value == '1') {
                $('#div_packing_size').hide();
            }
        });
    });
    function hideSuccessMessage() {
        setTimeout(function () {
            $('.alert-success').hide();
        }, 2000);

    }

    $(document).ready(function () {
        $("#form-productsaleedit").submit(function (e) {
            var product_standard_arr = new Array();
            $.each($("input[name='product_standard[]']:checked"), function () {
                product_standard_arr.push($(this).val());
            });
            if (product_standard_arr.length === 0) {
                var orther_product_standard = $("#product_standard").val();
                if (orther_product_standard.length <= 0) {
                    $('#ms_product_standard').css({
                        'color': '#a94442',
                        'background-color': 'white',
                        'font-size': '15px'
                    });
                    $("#ms_product_standard").html("<?php echo trans('messages.ms_product_standard')?>");
                }
                return false;
            }
        })
    });

    $('#add_packing').on('click', function () {
        /*if($('#add_packing').not(':checked').length){
         //alert('Not checked');
         $("#box-packing").html('');
         }else{
         var theHtml = $('#use-it-check-add_packing').html();
         $("#box-packing").html(theHtml);
         $("#form-productsaleedit").validator('update');
         //alert('Checked')
         }*/
        var add_packing = $('#add_packing').val();
        if (add_packing == 1) {
            var theHtml = $('#use-it-check-add_packing').html();
            $("#box-packing").html(theHtml);
            $("#form-productsaleedit").validator('update');
            $('#package_unit_form').attr('required', 'required');
        } else {
            $('#package_unit_form').removeAttr('required');
        }

    });
    $('#un_add_packing').on('click', function () {
        $("#box-packing").html('');
        $("#form-productsaleedit").validator('update');
    });
</script>
@endpush
@section('content')
    @include('shared.usermenu', array('setActive'=>'iwanttobuy'))
    <br/>
    <form action="{{ url('user/productbuyedit/'.$item->id) }}" method="post" class="form-inline"
          id="form-productsaleedit"
          data-toggle="validator" role="form" enctype="multipart/form-data">
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
                    <h2 id="head-title"> {{ $item->id ==0 ? trans('messages.add_buy') : trans('messages.edit_buy')}}</h2>
                </div>
                <div class="pull-right">
                    <button type="submit" class="btn btn-primary">
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
        <div class="panel panel-default" style="margin-top: 20px;">
            <div class="panel-heading">
                <strong>{{ trans('messages.product_info') }}</strong>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-6 {{ $errors->has('productcategorys_id') ? 'has-error' : '' }}">
                        <strong>
                            * {{ trans('validation.attributes.productcategorys_id') }} :
                        </strong>
                        <select id="productcategorys_id" name="productcategorys_id"
                                class="form-control min-width-100pc"
                                data-error='{{trans('validation.attributes.message_validate_productcategorys_id')}}'
                                required="required">
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
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group  col-md-6 {{ $errors->has('product_title') ? 'has-error' : '' }}">
                        <strong>
                            * {{ trans('validation.attributes.products_id') }} :
                        </strong>
                        {!! Form::text('fake_products_name', $product_name->product_name_th, array('placeholder' => trans('validation.attributes.products_id'),'class' => 'form-control min-width-100pc typeahead','data-error'=>trans('validation.attributes.message_validate_products_id'),'required'=>'required')) !!}
                        <input type="hidden" id="products_id" name="products_id" value="{{ $item->products_id }}">
                        <div class="help-block with-errors"></div>
                    </div>

                    @if(isset($standards))
                        <div class="form-group col-md-12 pd-top-10">
                            <strong style="display: block; padding-bottom: 5px;">
                                * {{ trans('validation.attributes.guarantee') }} :
                            </strong>
                            @for($i = 0 ; $i < count($standards) ; $i++)
                                <label class="checkbox-inline">
                                    <input name="product_standard[]" type="checkbox"
                                           value="{{ $standards[$i]->id}}" {{ $standards[$i]->checked ? "checked" : ""}}>
                                    {{$standards[$i]->name}}
                                </label>
                            @endfor
                            <span> {{ trans('messages.text_specify') }} :</span>
                            {!! Form::text('product_other_standard', $item->product_other_standard, array('class' => 'form-control','id' => 'product_standard')) !!}
                            <br/>
                            <small class="alert-danger" id="ms_product_standard"></small>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <input type="radio" name="add_packing" id="un_add_packing" value="-1"
                               @if($item->add_packing == -1) checked @elseif(Request::input('id') == 0) checked @endif>
                        {{ trans('validation.attributes.uncheckbox_product_package') }}
                        <input type="radio" name="add_packing" id="add_packing" value="1"
                               @if($item->add_packing == 1) checked @endif>
                        {{ trans('validation.attributes.checkbox_product_package') }}
                        <hr/>
                    </div>
                </div>
                <div class="row" id="box-packing">
                    @if($item->add_packing == 1)
                        <div id="div_packing_size"
                             class="form-group col-xs-6 col-sm-6 col-md-4 {{ $errors->has('packing_size') ? 'has-error' : ''}}">
                            <strong>* {{ trans('validation.attributes.product_package_size') }} :</strong>
                            {!! Form::number('packing_size', $item->packing_size, array('placeholder' => trans('validation.attributes.product_package_size'),'class' => 'form-control','data-error'=>trans('validation.attributes.message_validate_product_package_size'),'required'=>'required')) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-xs-6 col-sm-6 col-md-4 {{ $errors->has('units_package') ? 'has-error' : '' }}">
                            <strong>
                                * {{ trans('validation.attributes.units_package') }} :
                            </strong>
                            <select id="package_unit_form" name="package_unit" class="form-control"
                                    data-error='{{trans('validation.attributes.message_validate_units')}}'
                                    required="required">
                                <option value="">{{ trans('validation.attributes.units') }}</option>
                                @foreach ($unitsItem as $key => $unit)
                                    @if($item->package_unit == $unit->units_th)
                                        <option selected value="{{ $unit->units_th }}">
                                            {{ $unit->units_th }}
                                        </option>
                                    @else
                                        <option value="{{ $unit->units_th }}">
                                            {{ $unit->units_th }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="col-md-12">
                            <hr/>
                        </div>
                    @endif
                </div>
                <div class="row" style="margin-top: 15px;">
                    <div class="form-group pd-top-10 col-md-6 {{ $errors->has('volumnrange_start')||$errors->has('volumnrange_end') ? 'has-error' : '' }}">
                        <strong>
                            * {{trans('validation.attributes.volumnrange_product_need_buy')}} :
                        </strong>
                        {!! Form::text('volumnrange_start', $item->volumnrange_start, array('placeholder' => trans('validation.attributes.volumnrange_product_need_buy'),'class' => 'form-control min-width-100pc','data-error'=>trans('validation.attributes.message_validate_volumnrange_start'),'required'=>'required')) !!}
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group pd-top-10 col-md-6 {{ $errors->has('units') ? 'has-error' : '' }}">
                        <strong>
                            * {{ trans('validation.attributes.units') }} :
                        </strong>
                        <select id="units" name="units" class="form-control min-width-100pc"
                                data-error='{{trans('validation.attributes.message_validate_min_order_units')}}'
                                required="required">
                            <option value="">{{ trans('validation.attributes.units') }}</option>
                            @foreach ($unitsItem as $key => $unit)
                                @if($item->units == $unit->units_th)
                                    <option selected
                                            value="{{ $unit->units_th }}">{{ $unit->units_th }}</option>
                                @else
                                    <option value="{{ $unit->units_th }}">{{ $unit->units_th }}</option>
                                @endif
                            @endforeach
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="row" style="margin-top: 15px;">
                    <div class="form-group pd-top-10 col-md-6 {{ $errors->has('pricerange_start_unit')||$errors->has('pricerange_end') ? 'has-error' : '' }}">
                        <strong>
                            * {{ trans('validation.attributes.pricerange_start_unit') }} ({{trans('messages.baht')}}) :
                        </strong>
                        {!! Form::text('pricerange_start', $item->pricerange_start, array('placeholder' => trans('validation.attributes.pricerange_start_unit'),'class' => 'form-control min-width-100pc','data-error'=>trans('validation.attributes.message_validate_volumnrange_start'),'required'=>'required')) !!}
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group pd-top-10  col-md-6 {{ $errors->has('pricerange_end_unit')||$errors->has('pricerange_end') ? 'has-error' : '' }}">
                        <strong>
                            * {{ trans('validation.attributes.pricerange_end_unit') }} (({{trans('messages.baht')}})) :
                        </strong>
                        {!! Form::text('pricerange_end', $item->pricerange_end, array('placeholder' => trans('validation.attributes.pricerange_end_unit'),'class' => 'form-control min-width-100pc','data-error'=>trans('validation.attributes.message_validate_pricerange_end'),'required'=>'required')) !!}
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="row" style="margin-top: 15px;">
                    <div class="form-group pd-top-10 col-md-6 {{ $errors->has('province') ? 'has-error' : '' }}">
                        <strong>
                            {{ trans('validation.attributes.product_province_selling') }} :
                        </strong>
                        <select id="province" name="province_selling" class="form-control min-width-100pc">
                            <option value="0">{{ trans('messages.allprovince') }}</option>
                            @foreach ($provinceItem as $key => $province)
                                @if($item->province_selling == $province->PROVINCE_ID)
                                    <option selected
                                            value="{{ $province->PROVINCE_ID }}">{{ $province->PROVINCE_NAME }}</option>
                                @else
                                    <option value="{{ $province->PROVINCE_ID }}">{{ $province->PROVINCE_NAME }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group pd-top-10 col-md-6 {{ $errors->has('grade') ? 'has-error' : '' }}">
                        <strong> {{ trans('messages.text_grade') }} :</strong>
                        <select id="grade" name="grade" class="form-control min-width-100pc">
                            @foreach ($grades as $key => $value)
                                <option>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <br/>
                </div>
            </div>
        </div>
        </div>

    </form>
    <div id="use-it-check-add_packing" style="display:none;">
        <div id="div_packing_size"
             class="form-group col-xs-6 col-sm-6 col-md-4 {{ $errors->has('packing_size') ? 'has-error' : ''}}">
            <strong>* {{ trans('validation.attributes.product_package_size') }} :</strong>
            {!! Form::number('packing_size', $item->packing_size, array('placeholder' => trans('validation.attributes.product_package_size'),'class' => 'form-control','data-error'=>trans('validation.attributes.message_validate_product_package_size'),'required'=>'required')) !!}
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group col-xs-6 col-sm-6 col-md-4 {{ $errors->has('units_package') ? 'has-error' : '' }}">
            <strong>
                * {{ trans('validation.attributes.units_package') }} :
            </strong>
            <select id="package_unit" name="package_unit" class="form-control"
                    data-error='{{trans('validation.attributes.message_validate_units')}}'>
                <option value="">{{ trans('validation.attributes.units') }}</option>
                @foreach ($unitsItem as $key => $unit)
                    @if($item->package_unit == $unit->{ "units_th"})
                        <option selected value="{{ $unit->units_th }}">
                            {{ $unit->units_th }}
                        </option>
                    @else
                        <option value="{{ $unit->units_th }}">
                            {{ $unit->units_th }}
                        </option>
                    @endif
                @endforeach
            </select>
            <div class="help-block with-errors"></div>
        </div>
        <div class="col-md-12">
            <hr/>
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
@stop
