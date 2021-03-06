@extends('layouts.main')
@push('scripts')
<script src="{{ asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
<script src="{{url('bootstrap-validator/js/validator.js')}}"></script>
<script>
    var product_category_value = 0;
    CKEDITOR.replace('product_description');
    $('#btnDelete').on('click', function (e) {
        if (confirm('{{ trans('messages.confirm_delete', ['attribute' => $item->product_title]) }}')) {
            $.get('{{ url('user/information') }}/removeproduct/ajax-state?stateid={{ $item->id }}', function (data) {
                window.location.href = "{{ url('user/iwanttosale') }}";
            });
        }
    });

    setTimeout(function () {
        var itemcategory = '{{ $item->id==0? old('productcategorys_id') : $item->productcategorys_id }}';
        if (itemcategory != "")
            $("#productcategorys_id").val({{ $item->id==0? old('productcategorys_id') : $item->productcategorys_id }}).change();

        var itemprovince_source = '{{ $item->province_source==""? old('province_source') : $item->province_source }}';
        {{--if (itemprovince_source != "")--}}
            {{--$("#province_source").val('{{ $item->province_source==""? old('province_source') : $item->province }}').change();--}}
    }, 500);

    var products_array = [];

    function validate() {
        if (jQuery.inArray($('input[name=fake_products_name]').val(), products_array) == -1) 
        {
            $('input[name=fake_products_name]').val('');
            $('input[name=fake_products_name]').focus();
            $('input[name=fake_products_name]').validator('update');
            $('input[name=fake_products_name]').validator('validate');

            return true;
        }
        return true;
    }

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
        

        $(function()
        {
            if($('input[name=fake_products_name]').val() != '')
            {
                $.get('{{url('/information/create/ajax-state?search=true&productcategorys_id=')}}' + $('#products_id').val() + '&product_name_th='+$('input[name=fake_products_name]').val(), function(data)
                {
                    products_array = [];

                    $.map(data, function (product)
                    {
                        products_array[product.id] = product.product_name_th;
                    });                
                });
            }
        });


        //Selling Period
        $('input[type=radio][name=selling_period]').change(function () {
            if (this.value == 'period') {
                $('.div_selling_period_date').show();
            } else if (this.value == 'year') {
                $('.div_selling_period_date').hide();
            }
        });


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
        initialViews();
        hideSuccessMessage();

    });

    function deleteImage(imageNo) {
        /*if(imageNo == 1){
         $("input[type=file], product1_file").val('');
         $('#img1').removeAttr('src')
         $('#img1').show();
         }else */
        if (imageNo == 2) {
            $("input[type=file], product2_file").val('');
            $("#product2_file_delete").val("1");
            $('#img2').removeAttr('src')
            $('#img2').show();
        } else if (imageNo == 3) {
            $("input[type=file], product3_file").val('');
            $("#product3_file_delete").val("1");

            $('#img3').removeAttr('src')
            $('#img3').show();
        }
    }

    function initialViews() {

        //Selling Period
        var selling_period = '<?php echo $item->selling_period?>';
        if (selling_period == 'year') {
            $('.div_selling_period_date').hide();
        } else if (selling_period == 'peri') {
            $('.div_selling_period_date').show();
        } else {
            $('.div_selling_period_date').hide();
            $("input[type=radio][name=selling_period]:first").attr('checked', true);
        }
    }

    function hideSuccessMessage() {
        setTimeout(function () {
            $('.alert-success').hide();
        }, 2000);

    }

    function clone() {
        $("input[name=id]").val('0');
        $("#btn-clone").hide();
        $("#clone-alert").alert();
        $("#clone-alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#clone-alert").slideUp(500);
        });
        $("#head-title").text('{{ trans('messages.add_sale') }}');
        $('#file1').val('')
        $('#file1').attr('required', 'required');
        $('#file1').attr('data-error', '{{ trans('validation.attributes.message_validate_product1_file') }}'); // ข้อความที่จะแสดง

        $('#file2').val('')
        $('#file3').val('')
        $('#img1').removeAttr('src')
        $('#img1').hide();
        $('#img2').removeAttr('src')
        $('#img2').hide();
        $('#img3').removeAttr('src')
        $('#img3').hide();
        $('.delete-img').hide();

    }

    $(document).ready(function () {
        $("#form-productsaleedit").submit(function (e) {
            var volumn = parseInt($("input[name=volumn]").val());
            var min_order = parseInt($("input[name=min_order]").val());
            var product_stock = parseInt($("input[name=product_stock]").val());

            var selling_type = new Array();
            $.each($("input[name='selling_type[]']:checked"), function () {
                selling_type.push($(this).val());
            });
            $("#ms_selling_type").empty();
            if (selling_type.length === 0) {
                $('#ms_selling_type').css({'color': '#a94442', 'background-color': 'white', 'font-size': '15px'});
                $("#ms_selling_type").html("<?php echo trans('messages.ms_selling_type')?>");
                return false;
            }
            var markets = new Array();
            $.each($("input[name='product_markets[]']:checked"), function () {
                markets.push($(this).val());
            });
            $("#ms_product_markets").empty();
            if (markets.length <= 0) {
                $('#ms_product_markets').css({'color': '#a94442', 'background-color': 'white', 'font-size': '15px'});
                $("#ms_product_markets").html("<?php echo trans('messages.ms_market')?>");
                return false;
            }

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

            if (min_order <= 0) {
                $("input[name=min_order]").focus();
                $('#ms_min_order').css({'color': '#a94442', 'background-color': 'white', 'font-size': '15px'});
                $("#ms_min_order").html("<?php echo trans('messages.ms_min_order')?>");
                return false;
            }
            if (product_stock <= -1) {
                $("input[name=product_stock]").focus();
                $('#ms_product_stock').css({'color': '#a94442', 'background-color': 'white', 'font-size': '15px'});
                $("#ms_product_stock").html("<?php echo trans('messages.ms_product_stock')?>");
                return false;
            }
            if (volumn != '' && product_stock != '') {
                if (product_stock > volumn) {
                    $("input[name=product_stock]").focus();
                    $('#ms_product_stock').css({'color': '#a94442', 'background-color': 'white', 'font-size': '15px'});
                    $("#ms_product_stock").html("<?php echo trans('messages.ms_product_stock')?>");
                    return false;
                }
            }

            var file1 = $("#file1");
            if (file1 == null) {
                file1.addClass('has-error');
                $('html, body').animate({
                    scrollTop: file1.offset().top - 50
                }, 500);
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
        }else {
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
    @include('shared.usermenu', array('setActive'=>'iwanttosale'))
    <br/>
    <form action="{{ url('user/productsaleupdate') }}" id="form-productsaleedit" method="post"
          data-toggle="validator" role="form" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{--{{ Form::hidden('product1_file_temp', $item->product1_file) }}--}}
        {{--{{ Form::hidden('product2_file_temp', $item->product2_file) }}--}}
        {{--{{ Form::hidden('product3_file_temp', $item->product3_file) }}--}}
        {{ Form::hidden('product2_file_delete', '0', array('id'=>'product2_file_delete')) }}
        {{ Form::hidden('product3_file_delete', '0', array('id'=>'product3_file_delete')) }} {{--เปลี่ยนตรงนี้เป็น 1 ถ้ากดลบ / ถ้ามันเป็น 0 submit ได้ปกติ แต่ถ้า jquery เปลี่ยนมันเป็น 1 จะ error--}}
        {{ Form::hidden('users_id', $useritem->id) }}
        {{ Form::hidden('iwantto', $useritem->iwantto) }}
        {{ Form::hidden('id', $item->id) }}
        <input name="_method" type="hidden" value="post">
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
        <div id="clone-alert" class="alert alert-info" style="display: none">
            <strong>{{trans('messages.clone_product_success')}} </strong>
        </div>
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2 id="head-title"> {{ $item->id ==0 ? trans('messages.add_sale') : trans('messages.edit_sale')}}</h2>
                </div>
                <div class="pull-right">
                    @if($item->id != 0)
                        <button id="btn-clone" type="button" class="btn btn-info" onclick="clone();">
                            <span class="glyphicon glyphicon-copy" aria-hidden="true"></span>
                            {{ trans('messages.clone_product')}}</button>
                    @endif
                    <button type="submit" class="btn btn-primary" onclick="return validate();">
                    {{--<button type="submit" class="btn btn-primary">--}}
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                        {{ trans('messages.button_save')}}
                    </button>
                    @if($showDelete)
                        <button id="btnDelete" type="button" class="btn btn-danger">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            {{ trans('messages.button_delete')}}
                        </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- start form panel 1 --}}
        <div class="panel panel-default" style="margin-top: 20px;">
            <div class="panel-heading">
                <strong>{{ trans('messages.product_info') }}</strong>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 ">
                        <label class="control-label">* <strong>รูปแบบการขาย :</strong></label>

                        @if($item->selling_type == 'retail')
                            <input type="checkbox" name="selling_type[]" value="retail" checked> {{trans('messages.retail')}}
                            <input type="checkbox" name="selling_type[]" value="wholesale"> {{trans('messages.wholesale')}}
                        @elseif($item->selling_type == 'wholesale')
                            <input type="checkbox" name="selling_type[]" value="retail"> {{trans('messages.retail')}}
                            <input type="checkbox" name="selling_type[]" value="wholesale" checked> {{trans('messages.wholesale')}}
                        @elseif($item->selling_type == 'all')
                            <input type="checkbox" name="selling_type[]" value="retail" checked> {{trans('messages.retail')}}
                            <input type="checkbox" name="selling_type[]" value="wholesale" checked> {{trans('messages.wholesale')}}
                        @else
                            <input type="checkbox" name="selling_type[]" value="retail" checked> {{trans('messages.retail')}}
                            <input type="checkbox" name="selling_type[]" value="wholesale"> {{trans('messages.wholesale')}}
                        @endif
                        <br/>
                        <small class="alert-danger" id="ms_selling_type"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 form-inline" style="margin-top: 15px;">
                        <strong style="margin-right: 20px;">* {{ trans('validation.attributes.market') }}</strong>
                        @for($i = 0 ; $i < count($markets) ; $i++)
                            <label class="checkbox-inline">
                                <input name="product_markets[]" type="checkbox"
                                       value="{{ $markets[$i]->id}}" {{ $markets[$i]->checked ? "checked" : ""}}>
                                {{$markets[$i]->market_title_th}}
                            </label>
                        @endfor
                        <br/>
                        <small class="alert-danger" id="ms_product_markets"></small>
                    </div>
                </div>
                {{-- row--}}
                <div class="row" style="margin-top: 15px;">
                    <div class="form-group col-xs-4 col-sm-6 col-md-4 {{ $errors->has('productcategorys_id') ? 'has-error' : '' }}">
                        <strong>
                            * {{ trans('validation.attributes.productcategorys_id') }} :
                        </strong>
                        <select id="productcategorys_id" name="productcategorys_id" class="form-control"
                                data-error='{{trans('validation.attributes.message_validate_productcategorys_id')}}'
                                required="required">
                            <option value="">
                                {{ trans('messages.menu_product_category') }}
                            </option>
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
                    <div class="form-group col-xs-4 col-sm-6 col-md-4 {{ $errors->has('products_id') ? 'has-error' : '' }}">
                        <strong>
                            * {{ trans('validation.attributes.products_id') }} :
                        </strong>
                        {!! Form::text('fake_products_name', $product_name->product_name_th, array('placeholder' => trans('validation.attributes.products_id'),'class' => 'form-control typeahead','data-error'=>trans('validation.attributes.message_validate_products_id'),'required'=>'required')) !!}
                        <input type="hidden" id="products_id" name="products_id" value="{{ $item->products_id }}">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="col-xs-4 col-sm-6 col-md-4 {{ $errors->has('product_title') ? 'has-error' : '' }}">
                        <strong>{{ trans('validation.attributes.product_title') }}
                            :</strong>
                        {!! Form::text('product_title', $item->product_title, array('placeholder' => trans('validation.attributes.product_title'),'class' => 'form-control')) !!}
                    </div>
                </div>
                {{-- row--}}
                @if(isset($standards))
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12 form-inline">
                            <strong style="margin-right: 20px;">* {{ trans('validation.attributes.guarantee') }}</strong>
                            @for($i = 0 ; $i < count($standards) ; $i++)
                                <label class="checkbox-inline">
                                    <input name="product_standard[]" type="checkbox"
                                           value="{{ $standards[$i]->id}}" {{ $standards[$i]->checked ? "checked" : ""}}>
                                    {{$standards[$i]->name}}
                                </label>
                            @endfor
                            <span style="margin-left: 10px">{{trans('messages.other_text')}}</span>
                            {!! Form::text('product_other_standard', $item->product_other_standard, array('class' => 'form-control','id' => 'product_standard')) !!}
                            <br/>
                            <small class="alert-danger" id="ms_product_standard"></small>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-xs-4 col-sm-6 col-md-4 {{ $errors->has('province') ? 'has-error' : '' }}">
                        <strong> {{ trans('validation.attributes.production_province') }} : </strong>
                        <select id="province_source" name="province_source" class="form-control">
                            <option value="0">{{ trans('messages.allprovince') }}</option>
                            @foreach ($provinceItem as $key => $province)
                                @if($item->province_source == $province->PROVINCE_ID)
                                    <option selected
                                            value="{{ $province->PROVINCE_ID }}">{{ $province->PROVINCE_NAME }}</option>
                                @else
                                    <option value="{{ $province->PROVINCE_ID }}">{{ $province->PROVINCE_NAME }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-4 col-sm-6 col-md-4 {{ $errors->has('province_selling') ? 'has-error' : '' }}">
                        <strong> {{ trans('validation.attributes.product_province_selling') }} :</strong>
                        <select id="province_selling" name="province_selling" class="form-control">
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
                    <div class="col-xs-4 col-sm-6 col-md-4">
                        <strong> {{ trans('validation.attributes.sequence') }} :</strong>
                        {!! Form::number('sequence', $item->sequence != '' ? $item->sequence : '1', array('class' => 'form-control')) !!}
                    </div>
                </div>

            </div>
        </div>

        {{-- start form panel 2 --}}
        <div class="panel panel-default" style="margin-top: 20px;">
            <div class="panel-heading">
                <strong>{{ trans('messages.product_sale_info') }}</strong>
            </div>
            <div class="panel-body">
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
                    <div class="form-group col-xs-6 col-sm-6 col-md-4 {{ $errors->has('volumn') ? 'has-error' : '' }}">
                        <strong>
                            * {{ trans('validation.attributes.volumn') }} :
                        </strong>
                        {!! Form::number('volumn', $item->volumn, array('placeholder' => trans('validation.attributes.volumn'),'class' => 'form-control','data-error'=>trans('validation.attributes.message_validate_volumn'),'required'=>'required','min'=>'1')) !!}
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group col-xs-6 col-sm-6 col-md-4">
                        <strong>
                            * {{ trans('validation.attributes.min_order') }} :
                        </strong>
                        {!! Form::number('min_order', $item->min_order != '' ? $item->min_order : '1', array('placeholder' => trans('validation.attributes.min_order'),'class' => 'form-control','data-error'=>trans('validation.attributes.message_validate_min_order'),'min'=>'1','required'=>'required')) !!}
                        <div class="help-block with-errors"></div>
                        <small class="alert-danger" id="ms_min_order"></small>
                    </div>
                    <div class="form-group col-xs-6 col-sm-6 col-md-4 {{ $errors->has('unit') ? 'has-error' : '' }}">
                        <strong>* {{ trans('validation.attributes.units') }} :</strong>
                        <select id="units" name="units" class="form-control"
                                data-error={{trans('validation.attributes.message_validate_min_order_units')}} required='required'>
                            <option value="">{{ trans('validation.attributes.units') }}</option>
                            @foreach ($unitsItem as $key => $unit)
                                @if($item->units == $unit->units_th)
                                    <option value="{{ $unit->units_th }}" selected="selected">
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
                </div>
                <div class="row " style="margin-top: 15px;">
                    <div class="form-group col-xs-6 col-sm-6 col-md-4 {{ $errors->has('price') ? 'has-error' : '' }}">
                        <strong>
                            * {{ trans('validation.attributes.price') }} :
                        </strong>
                        {!! Form::number('price', $item->price, array('placeholder' => trans('validation.attributes.price'),'class' => 'form-control','data-error'=>trans('validation.attributes.message_validate_start_date'),'required'=>'required')) !!}
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-4">
                        <strong>
                            * {{ trans('validation.attributes.product_stock') }} :
                        </strong>
                        {!! Form::number('product_stock', $item->product_stock != '' ? $item->product_stock : '0', array('placeholder' => trans('validation.attributes.product_stock'),'class' => 'form-control','data-error'=>trans('validation.attributes.message_validate_product_stock'),'required'=>'required')) !!}
                        <small class="alert-danger" id="ms_product_stock"></small>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group col-xs-6 col-sm-6 col-md-4 {{ $errors->has('grade') ? 'has-error' : '' }}">
                        <strong>เกรด :</strong>
                        <select id="grade" name="grade" class="form-control">
                            @foreach ($grades as $key => $value)
                                <option @if($item->grade == $value) selected @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row " style="margin-top: 15px;">
                    <div class="col-xs-4 col-sm-4 col-md-4 ">
                        <label class="control-label">
                            <strong>{{ trans('validation.attributes.selling_period') }} :</strong>
                        </label>
                        <input type="radio" name="selling_period"
                               value="year" {{ $item->selling_period == 'year'? 'checked="checked"' : '' }}> ตลอดปี
                        <input type="radio" name="selling_period"
                               value="period" {{ $item->selling_period == 'peri'? 'checked="checked"' : '' }}>
                        ช่วงเวลา

                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 div_selling_period_date form-inline">
                        <strong> {{ trans('validation.attributes.product_selling_start_date') }}:</strong>
                        <div class='input-group date' id='pick_start_date'>
                            {!! Form::text('start_selling_date', DateFuncs::convertToThaiDate($item->start_selling_date), array('placeholder' => trans('validation.attributes.product_selling_start_date'),'class' => 'form-control')) !!}
                            <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 div_selling_period_date form-inline {{ $errors->has('end_date') ? 'has-error' : '' }}">
                        <strong> {{ trans('validation.attributes.product_selling_end_date') }}:</strong>
                        <div class='input-group date' id='pick_end_date'>
                            {!! Form::text('end_selling_date', DateFuncs::convertToThaiDate($item->end_selling_date), array('placeholder' => trans('validation.attributes.product_selling_end_date'),'class' => 'form-control')) !!}
                            <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                        </div>
                    </div>

                </div>

                <div class="row " style="margin-top: 15px;">
                    <div class="col-xs-12 col-sm-12 col-md-12 form-inline {{ $errors->has('productstatus') ? 'has-error' : '' }}">
                        <strong>{{ trans('validation.attributes.productstatus') }}
                            :</strong>
                        <input type="radio" name="productstatus" id="productstatus1"
                               value="open" {{ $item->productstatus == 'open' || $item->productstatus == null? 'checked="checked"' : '' }} >
                        {{trans('messages.open_sale')}}
                        <input type="radio" name="productstatus" id="productstatus2"
                               value="soldout" {{ $item->productstatus == 'soldout'? 'checked="checked"' : '' }}>
                        {{trans('messages.sold_out')}}
                        <input type="radio" name="productstatus" id="productstatus3"
                               value="close" {{ $item->productstatus == 'close'? 'checked="checked"' : '' }}>
                        {{trans('messages.close_sale')}}
                    </div>
                </div>

            </div>
        </div>
        {{-- start form panel 3 --}}
        <div class="panel panel-default" style="margin-top: 20px;">
            <div class="panel-heading">
                <strong>{{ trans('validation.attributes.product_description') }}</strong>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 {{ $errors->has('product_description') ? 'has-error' : '' }}">
                        {!! Form::textarea('product_description', $item->product_description, array('placeholder' => trans('validation.attributes.product_description'),'class' => 'form-control','style'=>'height:100px')) !!}
                    </div>
                </div>
                <div class="row" style="margin-top: 15px">
                    <div class="form-group col-xs-6 col-sm-6 col-md-3 {{ $errors->has('product1_file') ? 'has-error' : '' }}">
                        <strong>* {{ trans('validation.attributes.product1_file') }}:</strong>
                        @if(!empty($item->product1_file))
                            {!! Form::file('product1_file', array('placeholder' => trans('validation.attributes.product1_file'),'class' => 'form-control', 'id'=>'file1')) !!}
                        @else
                            {!! Form::file('product1_file', array('placeholder' => trans('validation.attributes.product1_file'),'class' => 'form-control', 'id'=>'file1','data-error'=>trans('validation.attributes.message_validate_product1_file'),'required'=>'required')) !!}
                        @endif
                        <div class="help-block with-errors"></div>
                    </div>
                    @if($item != null && $item->product1_file != "")
                        <div class="col-xs-9 col-sm-9 col-md-9">
                            <img id="img1" style="height:260px; width:350px;" src="{{ url($item->product1_file) }}"
                                 alt=""
                                 class="img-thumbnail">
                        </div>
                        {{--<div class="col-xs-3 col-sm-3 col-md-3">
                            <input type="button" class="btn btn-danger" value="ลบรูป" onclick="deleteImage(1)">
                        </div>--}}
                    @endif
                </div>
                <div class="row" style="margin-top: 15px">
                    <div class="@if(empty($item->product2_file)) form-group @endif  col-xs-6 col-sm-6 col-md-3 {{ $errors->has('product2_file') ? 'has-error' : '' }}">
                        <strong>{{ trans('validation.attributes.product2_file') }}:</strong>
                        {!! Form::file('product2_file', array('placeholder' => trans('validation.attributes.product2_file'),'class' => 'form-control', 'id'=>'file2')) !!}
                    </div>
                    @if($item != null && $item->product2_file != "")
                        <div class="col-xs-9 col-sm-9 col-md-9">
                            <img id="img2" style="height:260px; width:350px;" src="{{ url($item->product2_file) }}"
                                 alt=""
                                 class="img-thumbnail">
                            <button type="button" class="delete-img btn btn-danger" onclick="deleteImage(2)">ลบรูป
                            </button>
                        </div>
                    @endif
                </div>
                <div class="row" style="margin-top: 15px">
                    <div class="@if(empty($item->product3_file)) form-group @endif  col-xs-6 col-sm-6 col-md-3 {{ $errors->has('product3_file') ? 'has-error' : '' }}">
                        <strong>{{ trans('validation.attributes.product3_file') }}:</strong>
                        {!! Form::file('product3_file', array('placeholder' => trans('validation.attributes.product3_file'),'class' => 'form-control', 'id'=>'file3')) !!}
                    </div>
                    @if($item != null && $item->product3_file != "")
                        <div class="col-xs-9 col-sm-9 col-md-9">
                            <img id="img3" style="height:260px; width:350px;" src="{{ url($item->product3_file) }}"
                                 alt=""
                                 class="img-thumbnail">
                            <button type="button" class="delete-img btn btn-danger" onclick="deleteImage(3)">ลบรูป
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        {{-- end panels --}}
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
    </div>
@stop
