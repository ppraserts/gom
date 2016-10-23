@extends ('layouts.plane')
@section ('body')
<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
            <br /><br /><br />
               @section ('login_panel_title',Lang::get('messages.login_panel_title'))
               @section ('login_panel_body')
                        <form role="form" method="POST" action="{{ url('/login') }}">
                           {{ csrf_field() }}
                            <fieldset>
                                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                    @if ($errors->has('email'))
                                        <label class="control-label" for="inputError">{{ $errors->first('email') }}</label>
                                    @endif
                                    <input class="form-control" placeholder="{{ Lang::get('validation.attributes.email') }}" name="email" type="email" autofocus>
                                </div>
                                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                    @if ($errors->has('password'))
                                        <label class="control-label" for="inputError">{{ $errors->first('password') }}</label>
                                    @endif
                                    <input class="form-control" placeholder="{{ Lang::get('validation.attributes.password') }}" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember">{{ Lang::get('validation.attributes.rememberme') }}
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-lg btn-success btn-block">
                                    {{ Lang::get('validation.attributes.btnLogin') }}
                                </button>
                                <!--
                                <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                    Forgot Your Password?
                                </a>
                              -->
                            </fieldset>
                        </form>

                @endsection
                @include('widgets.panel', array('as'=>'login', 'header'=>true))
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="text-align:center;">
                <a href="{{ url('/change/th') }}">
                    <img src="{{url('/images/icon_th.png')}}" alt="Image"/>
                </a>
                <a href="{{ url('/change/en') }}">
                  <img src="{{url('/images/icon_en.png')}}" alt="Image"/>
                </a>
            </div>
        </div>
    </div>
@stop
