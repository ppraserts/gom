<?php
function renderHTML($text)
{
    if($text != "")
      echo "<br/>".$text;
}
?>
@extends('layouts.main')
@section('content')
@include('shared.usermenu', array('setActive'=>'matchings'))
<br/>
<div class="row">
  <div class="col-md-4" style="padding-right:30px; text-align:center;">
      @if($item[0]->users_imageprofile != "")
        <img height="150" width="150" src="{{ url($item[0]->users_imageprofile) }}" alt="" class="img-circle">
        <br/><br/>
      @endif
      <div class="row" >
        <div class="col-md-12">
          @if($item[0]->users_membertype == "personal")
            {{ $item[0]->{"users_firstname_".Lang::locale()} }}
            {{ $item[0]->{"users_lastname_".Lang::locale()} }}
          @endif
          @if($item[0]->users_membertype == "company")
            {{ $item[0]->{"users_company_".Lang::locale()} }}
          @endif
          {{ renderHTML($item[0]->users_mobilephone) }}
          {{ renderHTML($item[0]->users_phone) }}
          {{ renderHTML($item[0]->users_fax) }}
          {{ renderHTML($item[0]->email) }}
          <br/><br/><button type="button" class="btn btn-primary">{{ trans('messages.inbox_message') }}</button>
          <br/><br/><button class="btn btn-default" type="button" onclick="window.history.back();">
            {{ trans('messages.backtoresult') }}
          </button>
        </div>
      </div>
  </div>
  <div class="col-md-8" style="background-color:#FFFFFF; padding:20px;">
    @if($item[0]->iwantto == "sale")
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
          <!-- Indicators -->
          <ol class="carousel-indicators">
            @if($item[0]->product1_file != "")
              <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            @endif
            @if($item[0]->product2_file != "")
              <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            @endif
            @if($item[0]->product3_file != "")
              <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            @endif
          </ol>

          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
            @if($item[0]->product1_file != "")
            <div class="item active">
              <img src="{{ url($item[0]->product1_file) }}" style="width:100%;" >
              <div class="carousel-caption"></div>
            </div>
            @endif
            @if($item[0]->product2_file != "")
            <div class="item">
              <img src="{{ url($item[0]->product2_file) }}" style="width:100%;">
              <div class="carousel-caption"></div>
            </div>
            @endif
            @if($item[0]->product3_file != "")
            <div class="item">
              <img src="{{ url($item[0]->product2_file) }}" style="width:100%;">
              <div class="carousel-caption"></div>
            </div>
            @endif
          </div>

          <!-- Controls -->
          <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
        <br/>
    @endif

    <span class="glyphicon glyphicon-map-marker"></span>
    {{ $item[0]->city }} {{ $item[0]->province }}
    <h3>{{ $item[0]->product_title }}</h3>
    <p>{!! $item[0]->product_description !!}</p>
    <h3>
      {{ Lang::get('validation.attributes.price') }} :

      @if($item[0]->iwantto == "buy")
        {{ floatval($item[0]->pricerange_start) }} - {{ floatval($item[0]->pricerange_end) }}
      @endif
      @if($item[0]->iwantto == "sale")
        @if($item[0]->is_showprice)
          {{ floatval($item[0]->price) }}
        @endif
        @if(!$item[0]->is_showprice)
          {{ trans('messages.product_no_price') }}
        @endif
      @endif
    </h3>
    <h3>
      {{ Lang::get('validation.attributes.volumn') }} :
      @if($item[0]->iwantto == "buy")
        {{ floatval($item[0]->volumnrange_start) }} - {{ floatval($item[0]->volumnrange_end) }}  {{ $item[0]->units }}
      @endif
      @if($item[0]->iwantto == "sale")
        {{ floatval($item[0]->volumn) }} {{ $item[0]->units }}
      @endif
    </h3>
  </div>
</div>
@stop
