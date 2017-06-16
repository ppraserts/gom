@extends('layouts.main')
@push('scripts')
<script type="text/javascript">
    $(function () {
        $('#iwanttosale').bind('change', function() {
            if (this.checked)
            {
               $('#users_qrcode_section').show();
            }
            else {
              if($('#iwanttobuy').is(':checked'))
              {
                $('#users_qrcode_section').hide();
              }
            }
        });

        $('#iwanttobuy').bind('change', function() {
            if (this.checked)
            {
               if($('#iwanttosale').is(':checked'))
               {
                 $('#users_qrcode_section').show();
               }
               else {
                 $('#users_qrcode_section').hide();
               }
            }
            else {
                $('#users_qrcode_section').show();
            }
        });

        $('#users_province').on('change', function(e){
            console.log(e);
            var state_id = e.target.value;

            $.get('{{ url('information') }}/create/ajax-state?province_id=' + state_id, function(data) {
                console.log(data);
                var option = '';
                $('#users_city').empty();
                $('#users_district').empty();

                //option += '<option value="">{{ Lang::get('validation.attributes.products_id') }}</option>';
                $.each(data, function(index,subCatObj){
                  option += '<option value="'+ subCatObj.AMPHUR_NAME + '">' + subCatObj.AMPHUR_NAME + '</option>';
                });
                $('#users_city').append(option);
                $( "#users_city" ).val({{ old('users_city') }});
                $( "#users_city" ).trigger( "change" );
            });
        });

        $('#users_city').on('change', function(e){
            console.log(e);
            var state_id = e.target.value;

            $.get('{{ url('information') }}/create/ajax-state?city_id=' + state_id, function(data) {
                console.log(data);
                var option = '';
                $('#users_district').empty();

                //option += '<option value="">{{ Lang::get('validation.attributes.products_id') }}</option>';
                $.each(data, function(index,subCatObj){
                  option += '<option value="'+ subCatObj.DISTRICT_NAME + '">' + subCatObj.DISTRICT_NAME + '</option>';
                });
                $('#users_district').append(option);
                $( "#users_district" ).val({{ old('users_district') }});
            });
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
                <div class="panel-heading">{{ trans('messages.menu_register') }} ({{ trans('messages.membertype_company') }})</div>
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
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('user/savecompanyregister') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('iwantto') ? ' has-error' : '' }}">
                            <label for="iwantto" class="col-md-4 control-label">* {{ Lang::get('validation.attributes.iwantto') }}</label>

                            <div class="col-md-6">
                              <label class="radio-inline">
                                  <input type="checkbox" name="iwantto[]" id="iwanttosale" value="sale" > {{ trans('messages.i_want_to_sale') }}
                              </label>
                              <label class="radio-inline">
                                  <input type="checkbox" name="iwantto[]" id="iwanttobuy" value="buy"> {{ trans('messages.i_want_to_buy') }}
                              </label>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('users_taxcode') ? ' has-error' : '' }}">
                            <label for="users_taxcode" class="col-md-4 control-label">* {{ Lang::get('validation.attributes.users_taxcode') }}</label>

                            <div class="col-md-6">
                                <input id="users_taxcode" type="text" class="form-control" name="users_taxcode" value="{{ old('users_taxcode') }}" autofocus>

                                @if ($errors->has('users_taxcode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('users_taxcode') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div id="users_qrcode_section" class="form-group{{ $errors->has('users_qrcode') ? ' has-error' : '' }}">
                            <label for="users_qrcode" class="col-md-4 control-label">{{ Lang::get('validation.attributes.users_qrcode') }}</label>

                            <div class="col-md-6">
                                <input id="users_qrcode" type="text" class="form-control" name="users_qrcode" value="{{ old('users_qrcode') }}" autofocus>

                                @if ($errors->has('users_qrcode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('users_qrcode') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if(isset($standards))
                            <div id="users_standard_section" class="form-group{{ $errors->has('users_standard') ? ' has-error' : '' }}">
                                <label for="users_standard" class="col-md-4 control-label">{{ Lang::get('validation.attributes.guarantee') }}</label>

                                <div class="col-md-6">
                                    @for($i = 0 ; $i < count($standards) ; $i++)
                                        <label class="checkbox-inline">
                                            <input name="users_standard[]" type="checkbox"
                                                   value="{{ $standards[$i]->id}}" {{ $standards[$i]->checked ? "checked" : ""}}>
                                            {{$standards[$i]->name}}
                                        </label>
                                    @endfor
                                        <div class="form-inline">
                                            <span style="margin-left: 10px">{{trans('messages.other_text')}}</span>
                                            {!! Form::text('other_standard', null, array('class' => 'form-control')) !!}
                                        </div>
                                    @if ($errors->has('users_standard'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('users_standard') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                        <div class="form-group{{ $errors->has('users_company_th') ? ' has-error' : '' }}">
                            <label for="users_company_th" class="col-md-4 control-label">* {{ Lang::get('validation.attributes.users_company_th') }}</label>

                            <div class="col-md-6">
                                <input id="users_company_th" type="text" class="form-control" name="users_company_th" value="{{ old('users_company_th') }}" autofocus>

                                @if ($errors->has('users_company_th'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('users_company_th') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('users_company_en') ? ' has-error' : '' }}">
                            <label for="users_company_en" class="col-md-4 control-label">* {{ Lang::get('validation.attributes.users_company_en') }}</label>

                            <div class="col-md-6">
                                <input id="users_company_en" type="text" class="form-control" name="users_company_en" value="{{ old('users_company_en') }}" autofocus>

                                @if ($errors->has('users_company_en'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('users_company_en') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('users_mobilephone') ? ' has-error' : '' }}">
                            <label for="users_mobilephone" class="col-md-4 control-label">{{ Lang::get('validation.attributes.users_mobilephone') }}</label>

                            <div class="col-md-6">
                                <input id="users_mobilephone" type="text" class="form-control" name="users_mobilephone" value="{{ old('users_mobilephone') }}" autofocus>

                                @if ($errors->has('users_mobilephone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('users_mobilephone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('users_phone') ? ' has-error' : '' }}">
                            <label for="users_phone" class="col-md-4 control-label">{{ Lang::get('validation.attributes.users_phone') }}</label>

                            <div class="col-md-6">
                                <input id="users_phone" type="text" class="form-control" name="users_phone" value="{{ old('users_phone') }}" autofocus>

                                @if ($errors->has('users_phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('users_phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('users_fax') ? ' has-error' : '' }}">
                            <label for="users_fax" class="col-md-4 control-label">{{ Lang::get('validation.attributes.users_fax') }}</label>

                            <div class="col-md-6">
                                <input id="users_fax" type="text" class="form-control" name="users_fax" value="{{ old('users_fax') }}" autofocus>

                                @if ($errors->has('users_fax'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('users_fax') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('users_addressname') ? ' has-error' : '' }}">
                            <label for="users_addressname" class="col-md-4 control-label">{{ Lang::get('validation.attributes.users_addressname') }}</label>

                            <div class="col-md-6">
                                <input id="users_addressname" type="text" class="form-control" name="users_addressname" value="{{ old('users_addressname') }}" autofocus>

                                @if ($errors->has('users_addressname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('users_addressname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('users_street') ? ' has-error' : '' }}">
                            <label for="users_street" class="col-md-4 control-label">{{ Lang::get('validation.attributes.users_street') }}</label>

                            <div class="col-md-6">
                                <input id="users_street" type="text" class="form-control" name="users_street" value="{{ old('users_street') }}" autofocus>

                                @if ($errors->has('users_street'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('users_street') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('users_province') ? ' has-error' : '' }}">
                            <label for="users_province" class="col-md-4 control-label">{{ Lang::get('validation.attributes.users_province') }}</label>

                            <div class="col-md-6">
                                <select id="users_province" name="users_province" class="form-control">
                                    <option value="">{{ trans('messages.allprovince') }}</option>
                                    @foreach ($provinceItem as $key => $province)
                                      @if(old('users_province') == $province->PROVINCE_NAME)
                                        <option selected value="{{ $province->PROVINCE_NAME }}">{{ $province->PROVINCE_NAME }}</option>
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
                        </div>
                        <div class="form-group{{ $errors->has('users_city') ? ' has-error' : '' }}">
                            <label for="users_city" class="col-md-4 control-label">{{ Lang::get('validation.attributes.users_city') }}</label>

                            <div class="col-md-6">
                                <select id="users_city" name="users_city" class="form-control">
                                </select>
                                @if ($errors->has('users_city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('users_city') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('users_district') ? ' has-error' : '' }}">
                            <label for="users_district" class="col-md-4 control-label">{{ Lang::get('validation.attributes.users_district') }}</label>

                            <div class="col-md-6">
                                <select id="users_district" name="users_district" class="form-control">
                                </select>
                                @if ($errors->has('users_district'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('users_district') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('users_postcode') ? ' has-error' : '' }}">
                            <label for="users_postcode" class="col-md-4 control-label">{{ Lang::get('validation.attributes.users_postcode') }}</label>

                            <div class="col-md-6">
                                <input id="users_postcode" type="text" class="form-control" name="users_postcode" value="{{ old('users_postcode') }}" autofocus>

                                @if ($errors->has('users_postcode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('users_postcode') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">* {{ Lang::get('validation.attributes.email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" >

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">* {{ Lang::get('validation.attributes.password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" >

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">{{ Lang::get('validation.attributes.password_confirmation') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('CaptchaCode') ? ' has-error' : '' }}">
                           <label class="col-md-4 control-label">* Captcha</label>

                           <div class="col-md-6">
                               {!! captcha_image_html('ContactCaptcha') !!}
                               <input class="form-control" type="text" id="CaptchaCode" name="CaptchaCode" style="margin-top:5px;">

                               @if ($errors->has('CaptchaCode'))
                                   <span class="help-block">
                                       <strong>{{ $errors->first('CaptchaCode') }}</strong>
                                   </span>
                               @endif
                           </div>
                       </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
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
