@extends('layouts.main')
@section('content')
<h3><span class="glyphicon glyphicon-list" aria-hidden="true"></span>  {{ trans('messages.sitemap') }}</h3>
<ul >
    <li class="active"><a href="{{ url('/') }}">{{ trans('messages.menu_travel') }}</a></li>
    <li><a href="{{ url('/news') }}">{{ trans('messages.menu_announcement') }}</a></li>
    <li><a href="{{ url('/faq') }}">{{ trans('messages.menu_faq') }}</a></li>
    <li><a href="{{ url('/contactus') }}">{{ trans('messages.menu_contactus') }}</a></li>
    <li><a href="{{ url('/sitemap') }}">{{ trans('messages.sitemap') }}</a></li>
    <li><a href="#" >{{ trans('messages.menu_openshop') }} <b class="caret"><!----></b></a>
      <ul >
        <li><a href="{{ url('user/chooseregister') }}" target="_self">{{ trans('messages.menu_register') }}</a></li>
      </ul>
    </li>
     <li><a href="{{ url('user/login') }}" target="_self">{{ trans('messages.menu_loginmarket') }}</a><b class="caret"><!----></b></a>    
      <ul >
        <li><a href="{{ url('user/password/reset') }}" target="_self">{{ trans('messages.forgotpassword') }}</a></li>
      </ul>
    </li>
   </ul>
@stop