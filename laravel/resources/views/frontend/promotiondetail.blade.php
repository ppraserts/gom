@extends('layouts.main')
@section('content')

    <div style="background-color: #fff; padding: 20px;">
    <img src="{{ url($promotion->image_file) }}" style="margin: auto;
    display: block;"/>
    <h3>{{ $promotion->promotion_title }}</h3>
    <p><b>{{ Lang::get('validation.attributes.product_description')}}</b> : {{ $promotion->promotion_description }}</p>
    <p><b>{{ Lang::get('validation.attributes.promotion_start_date')}}</b> : {{ $promotion->start_date }}</p>
    <p><b>{{ Lang::get('validation.attributes.promotion_end_date')}}</b> : {{ $promotion->end_date }}</p>
    </div>
@stop
