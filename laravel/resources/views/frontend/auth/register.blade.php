@extends('layouts.main')
@push('scripts')
<script src="{{url('bootstrap-validator/js/validator.js')}}"></script>
<script type="text/javascript">
    var is_first_time = false;
    $(function () {
        $('#datetimepicker1').datepicker({
            format: 'yyyy-mm-dd',
            language: 'th-th',
            autoclose: true,
            toggleActive: false,
            todayHighlight: false,
            todayBtn: false,
            startView: 2,
            maxViewMode: 2
        });

        $('#users_qrcode_section').hide();
        $('#users_standard_section').hide();
        @if(!empty(old('iwantto')))
            @if(in_array('sale', old('iwantto')))
                $('#users_qrcode_section').show();
                $('#users_standard_section').show();
            @endif
        @endif

        //$('#datetimepicker1').datepicker("update", new Date('1950-01-01'));
        $('#datetimepicker1').datepicker().on('show', function (e) {
            if (!is_first_time) {
                is_first_time = true;
                $('#datetimepicker1').datepicker("update", new Date('1950-01-01'));
            }
        });

        $('#users_province').on('change', function (e) {
            console.log(e);
            var state_id = e.target.value;

            $.get('{{ url('information') }}/create/ajax-state?province_id=' + state_id, function (data) {
                console.log(data);
                var option = '';
                $('#users_city').empty();
                $('#users_district').empty();

                $.each(data, function (index, subCatObj) {
                    option += '<option value="' + subCatObj.AMPHUR_NAME + '">' + subCatObj.AMPHUR_NAME + '</option>';
                });
                $('#users_city').append(option);
                $("#users_city").val('{{ old('users_city') }}');
                $("#users_city").trigger("change");
            });
        });

        $('#users_city').on('change', function (e) {
            console.log(e);
            var state_id = e.target.value;

            $.get('{{ url('information') }}/create/ajax-state?city_id=' + state_id, function (data) {
                console.log(data);
                var option = '';
                $('#users_district').empty();

                $.each(data, function (index, subCatObj) {
                    option += '<option value="' + subCatObj.DISTRICT_NAME + '">' + subCatObj.DISTRICT_NAME + '</option>';
                });
                $('#users_district').append(option);
                $("#users_district").val('{{ old('users_district') }}');
            });
        });

        setTimeout(function () {
            var itemprovince = '{{  old('users_province') }}';
            console.log('itemprovince = '+itemprovince);
            if (itemprovince != "")
                $("#users_province").val('{{ old('users_province') }}').change();
        }, 500);

        $('#iwanttosale').bind('change', function () {
            if (this.checked) {
                $('#users_qrcode_section').show();
                $('#users_standard_section').show();
            }
            else {

                $('#users_qrcode_section').hide();
                $('#users_standard_section').hide();

            }
        });

        $("#form").submit(function (e) {

            var wantto = new Array();
            var sale = false;
            $.each($("input[name='iwantto[]']:checked"), function () {
                wantto.push($(this).val());
                if ($(this).val() == 'sale') {
                    sale = true;
                }
            });

            var iwantto = $('#iwantto');
            if (wantto.length === 0) {
                iwantto.addClass("has-error");
//                $('#ms_wantto').css({'color': '#a94442', 'background-color': 'white', 'font-size': '15px'});
                $("#ms_selling_type").html("<?php echo trans('messages.ms_selling_type')?>");
                $('html, body').animate({
                    scrollTop: $('#iwantto').offset().top - 50
                }, 500);
                return false;
            } else {
                iwantto.removeClass("has-error");
            }

            if (sale) {
                var users_standard = new Array();
                $.each($("input[name='users_standard[]']:checked"), function () {
                    users_standard.push($(this).val());
                });
                var other_standard = $('#other_standard').val();
                if (users_standard.length === 0 && other_standard.length === 0) {
                    var users_standard_section = $('#users_standard_section');
                    users_standard_section.addClass("has-error");
//                    $('#ms_users_standard').css({'color': '#a94442', 'background-color': 'white', 'font-size': '15px'});
                    $("#ms_standard").html("<?php echo trans('messages.required_standard')?>");
                    $('html, body').animate({
                        scrollTop: users_standard_section.offset().top - 50
                    }, 500);
                    return false;
                }
            }

            return true;
        });

    });
</script>
@endpush
@section('content')
    <link href="{{ captcha_layout_stylesheet_url() }}" type="text/css" rel="stylesheet">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('messages.menu_register') }}
                        ({{ trans('messages.membertype_individual') }})
                    </div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-danger">
                                {{ session('status') }}
                            </div>
                        @endif
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
                        <form id="form" role="form" method="POST" action="{{ url('user/saveregister') }}"
                              data-toggle="validator">
                            {{ csrf_field() }}
                            <div class="row">
                                <div id="iwantto"
                                     class="col-md-offset-1 col-md-10 form-group{{ $errors->has('iwantto') ? ' has-error' : '' }}">
                                    <label for="iwantto"
                                           class="control-label">* {{ Lang::get('validation.attributes.iwantto') }}</label>


                                    <label class="radio-inline">
                                        <input type="checkbox" name="iwantto[]" id="iwanttosale"
                                               value="sale"
                                               @if(!empty(old('iwantto'))) @if(in_array('sale', old('iwantto'))) checked @endif @endif> {{ trans('messages.i_want_to_sale') }}
                                    </label>
                                    <label class="radio-inline">
                                        <input type="checkbox" name="iwantto[]" id="iwanttobuy"
                                               value="buy"
                                               @if(!empty(old('iwantto'))) @if(in_array('buy', old('iwantto'))) checked @endif @endif> {{ trans('messages.i_want_to_buy') }}
                                    </label>
                                    <div id="ms_selling_type" class="alert-danger help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-offset-1 col-md-10 form-group{{ $errors->has('users_idcard') ? ' has-error' : '' }}">
                                    <label for="users_idcard"
                                           class="control-label">* {{ Lang::get('validation.attributes.users_idcard') }}</label>


                                    <input id="users_idcard" type="text" class="form-control" name="users_idcard"
                                           value="{{ old('users_idcard') }}" maxlength="13" data-minlength="13"
                                           autofocus required>

                                    @if ($errors->has('users_idcard'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('users_idcard') }}</strong>
                                    </span>
                                    @endif

                                </div>
                            </div>
                            @if(isset($standards))
                                <div class="row">
                                    <div id="users_standard_section"
                                         class="col-md-offset-1 col-md-10 form-group{{ $errors->has('users_standard') ? ' has-error' : '' }}">
                                        <label for="users_standard"
                                               class="control-label">* {{ Lang::get('validation.attributes.guarantee') }}</label>

                                        @for($i = 0 ; $i < count($standards) ; $i++)
                                            <label class="checkbox-inline">
                                                <input name="users_standard[]" type="checkbox"
                                                       value="{{ $standards[$i]->id}}" {{ ($standards[$i]->checked || (!empty(old('users_standard')) && in_array($standards[$i]->id, old('users_standard')))) ? "checked" : ""}}>
                                                {{$standards[$i]->name}}
                                            </label>
                                        @endfor
                                        <div class="form-inline">
                                            <span style="margin-left: 10px">{{trans('messages.other_text')}}</span>
                                            {!! Form::text('other_standard', null, array('id' => 'other_standard','class' => 'form-control')) !!}
                                        </div>
                                        <div id="ms_standard" class="alert-danger help-block with-errors"></div>

                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div id="users_qrcode_section"
                                     class="col-md-offset-1 col-md-10 form-group{{ $errors->has('users_qrcode') ? ' has-error' : '' }}">
                                    <label for="users_qrcode"
                                           class="control-label">{{ Lang::get('validation.attributes.users_qrcode') }}</label>


                                    <input id="users_qrcode" type="text" class="form-control" name="users_qrcode"
                                           value="{{ old('users_qrcode') }}" autofocus>

                                    @if ($errors->has('users_qrcode'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('users_qrcode') }}</strong>
                                    </span>
                                    @endif

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-offset-1 col-md-5 form-group{{ $errors->has('users_firstname_th') ? ' has-error' : '' }}">
                                    <label for="users_firstname_th"
                                           class="control-label">* {{ Lang::get('validation.attributes.users_firstname_th') }}</label>


                                    <input id="users_firstname_th" type="text" class="form-control"
                                           name="users_firstname_th" value="{{ old('users_firstname_th') }}"
                                           autofocus required>

                                    @if ($errors->has('users_firstname_th'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('users_firstname_th') }}</strong>
                                    </span>
                                    @endif

                                </div>
                                <div class="col-md-5 form-group{{ $errors->has('users_lastname_th') ? ' has-error' : '' }}">
                                    <label for="users_lastname_th"
                                           class="control-label">* {{ Lang::get('validation.attributes.users_lastname_th') }}</label>

                                    <input id="users_lastname_th" type="text" class="form-control"
                                           name="users_lastname_th" value="{{ old('users_lastname_th') }}"
                                           autofocus required>

                                    @if ($errors->has('users_lastname_th'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('users_lastname_th') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-offset-1 col-md-5 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email"
                                           class="control-label">* {{ Lang::get('validation.attributes.email') }}</label>

                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-5 form-group{{ $errors->has('users_mobilephone') ? ' has-error' : '' }}">
                                    <label for="users_mobilephone"
                                           class="control-label">* {{ Lang::get('validation.attributes.users_mobilephone') }}</label>

                                    <input id="users_mobilephone" type="text" class="form-control"
                                           name="users_mobilephone" value="{{ old('users_mobilephone') }}"
                                           autofocus required>

                                    @if ($errors->has('users_mobilephone'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('users_mobilephone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-offset-1 col-md-10 form-group{{ $errors->has('users_addressname') ? ' has-error' : '' }}">
                                    <label for="users_addressname"
                                           class="control-label">{{ Lang::get('validation.attributes.users_addressname') }}</label>

                                    <input id="users_addressname" type="text" class="form-control"
                                           name="users_addressname" value="{{ old('users_addressname') }}" autofocus>

                                    @if ($errors->has('users_addressname'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('users_addressname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-offset-1 col-md-5 form-group{{ $errors->has('users_province') ? ' has-error' : '' }}">
                                    <label for="users_province"
                                           class="control-label">* {{ Lang::get('validation.attributes.users_province') }}</label>

                                    <select id="users_province" name="users_province" class="form-control" required>
                                        <option value="">{{ trans('messages.please_select') }}</option>
                                        @foreach ($provinceItem as $key => $province)
                                            @if(old('users_province') == $province->PROVINCE_NAME)
                                                <option selected
                                                        value="{{ $province->PROVINCE_NAME }}">{{ $province->PROVINCE_NAME }}</option>
                                            @else
                                                <option value="{{ $province->PROVINCE_NAME }}">{{ $province->PROVINCE_NAME }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if ($errors->has('users_province'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('users_province') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-md-5 form-group{{ $errors->has('users_city') ? ' has-error' : '' }}">
                                    <label for="users_city"
                                           class="control-label"> {{ Lang::get('validation.attributes.users_city') }}</label>

                                    <select id="users_city" name="users_city" class="form-control">
                                    </select>
                                    @if ($errors->has('users_city'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('users_city') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-offset-1 col-md-5 form-group{{ $errors->has('users_district') ? ' has-error' : '' }}">
                                    <label for="users_district"
                                           class="control-label"> {{ Lang::get('validation.attributes.users_district') }}</label>

                                    <select id="users_district" name="users_district" class="form-control">
                                    </select>
                                    @if ($errors->has('users_district'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('users_district') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-5 form-group{{ $errors->has('users_postcode') ? ' has-error' : '' }}">
                                    <label for="users_postcode"
                                           class="control-label">{{ Lang::get('validation.attributes.users_postcode') }}</label>

                                    <input id="users_postcode" type="text" class="form-control"
                                           name="users_postcode"
                                           value="{{ old('users_postcode') }}" autofocus>

                                    @if ($errors->has('users_postcode'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('users_postcode') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-offset-1 col-md-5 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password"
                                           class="control-label">* {{ Lang::get('validation.attributes.password') }}</label>

                                    <input id="password" type="password" class="form-control" name="password"
                                           data-minlength="6" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-md-5 form-group* {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <label for="password-confirm"
                                           class="control-label">* {{ Lang::get('validation.attributes.password_confirmation') }}</label>

                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required>

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>


                            </div>

                            <div class="row">

                                <div class="col-md-offset-1 col-md-5 form-group{{ $errors->has('CaptchaCode') ? ' has-error' : '' }}">
                                    <label class="control-label">* Captcha</label>


                                    {!! captcha_image_html('ContactCaptcha') !!}
                                    <input class="form-control" type="text" id="CaptchaCode" name="CaptchaCode"
                                           style="margin-top:5px;" required>

                                    @if ($errors->has('CaptchaCode'))
                                        <span class="help-block">
                                       <strong>{{ $errors->first('CaptchaCode') }}</strong>
                                   </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-offset-1 col-md-5 form-group">

                                    <button type="submit" class="btn btn-primary">
                                        {{ trans('messages.menu_register') }}
                                    </button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
