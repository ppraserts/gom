@extends('layouts.main')
@section('content')

<br/><br/>
<div style="text-align:center;">
<a href="{{ url('user/iwanttosale') }}" class="btn btn-circle btn-info">
  <img src="{{url('images/buy-icon.png')}}">
  <h1>{{ trans('messages.i_want_to_sale') }}</h1>
</a>

<a href="{{ url('user/iwanttobuy') }}" class="btn btn-circle btn-success">
  <img src="{{url('images/sell-icon.png')}}">
  <h1>{{ trans('messages.i_want_to_buy') }}</h1>
</a>
</div>
@stop
