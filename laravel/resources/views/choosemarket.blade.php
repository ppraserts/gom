@extends('layouts.main')
@section('content')
@include('shared.search')
<br/><br/>
<div style="text-align:center;">
<a href="{{ url('/choosemarket?market=sale') }}" class="btn btn-circle btn-info">
  <h1>{{ trans('messages.i_want_to_sale') }}</h1>
</a>

<a href="{{ url('/choosemarket?market=buy') }}" class="btn btn-circle btn-success">
  <h1>{{ trans('messages.i_want_to_buy') }}</h1>
</a>
</div>
@stop
