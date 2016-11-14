@extends('layouts.main')
@section('content')
<link href="{{ captcha_layout_stylesheet_url() }}" type="text/css" rel="stylesheet">
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
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
                            <label for="iwantto" class="col-md-4 control-label">{{ Lang::get('validation.attributes.iwantto') }}</label>

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
                            <label for="users_taxcode" class="col-md-4 control-label">{{ Lang::get('validation.attributes.users_taxcode') }}</label>

                            <div class="col-md-6">
                                <input id="users_taxcode" type="text" class="form-control" name="users_taxcode" value="{{ old('users_taxcode') }}" autofocus>

                                @if ($errors->has('users_taxcode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('users_taxcode') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('users_company_th') ? ' has-error' : '' }}">
                            <label for="users_company_th" class="col-md-4 control-label">{{ Lang::get('validation.attributes.users_company_th') }}</label>

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
                            <label for="users_company_en" class="col-md-4 control-label">{{ Lang::get('validation.attributes.users_company_en') }}</label>

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
                        <div class="form-group{{ $errors->has('users_district') ? ' has-error' : '' }}">
                            <label for="users_district" class="col-md-4 control-label">{{ Lang::get('validation.attributes.users_district') }}</label>

                            <div class="col-md-6">
                                <input id="users_district" type="text" class="form-control" name="users_district" value="{{ old('users_district') }}" autofocus>

                                @if ($errors->has('users_district'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('users_district') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('users_city') ? ' has-error' : '' }}">
                            <label for="users_city" class="col-md-4 control-label">{{ Lang::get('validation.attributes.users_city') }}</label>

                            <div class="col-md-6">
                                <input id="users_city" type="text" class="form-control" name="users_city" value="{{ old('users_city') }}" autofocus>

                                @if ($errors->has('users_city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('users_city') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('users_province') ? ' has-error' : '' }}">
                            <label for="users_province" class="col-md-4 control-label">{{ Lang::get('validation.attributes.users_province') }}</label>

                            <div class="col-md-6">
                                <input id="users_province" type="text" class="form-control" name="users_province" value="{{ old('users_province') }}" autofocus>

                                @if ($errors->has('users_province'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('users_province') }}</strong>
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
                            <label for="email" class="col-md-4 control-label">{{ Lang::get('validation.attributes.email') }}</label>

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
                            <label for="password" class="col-md-4 control-label">{{ Lang::get('validation.attributes.password') }}</label>

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
                           <label class="col-md-4 control-label">Captcha</label>

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
