<?php
function renderHTML($text)
{
    if ($text != "")
        echo "<br/>" . $text;
}

?>
@extends('layouts.main')
@section('content')
    @include('shared.usermenu', array('setActive'=>'matchings'))
    <br/>
    <div class="row">
        <div class="col-lg-12">
        <div class="col-md-4" style="padding-right:30px; text-align:center;">
            @if($user->id == $productRequest->users_id)
                <a href="{{ url('user/productsaleedit/'.$productRequest->id)  }}" class="btn btn-primary"><span
                            class="glyphicon glyphicon-pencil"></span> {{trans('messages.edit')}}</a>
            @else
                @if($productRequest->users_imageprofile != "")
                    <img height="150" width="150" src="{{ url($productRequest->users_imageprofile) }}" alt=""
                         class="img-circle">
                    <br/><br/>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        {{--@if($useritem->id == $item->)--}}
                        @if($productRequest->users_membertype == "personal")
                            {{ $productRequest->users_firstname .Lang::locale() }}
                            {{ $productRequest->users_lastname .Lang::locale() }}
                        @endif
                        @if($productRequest->users_membertype == "company")
                            {{ $productRequest->users_company .Lang::locale() }}
                        @endif
                        {{ renderHTML($productRequest->users_mobilephone) }}
                        {{ renderHTML($productRequest->users_phone) }}
                        {{ renderHTML($productRequest->users_fax) }}
                        {{ renderHTML($productRequest->email) }}
                        <br/><br/>
                        <button type="button" class="btn btn-primary">{{ trans('messages.inbox_message') }}</button>
                        <br/><br/>

                    </div>
                </div>


                @if($productRequest['selling_type'] == "all" || $productRequest['selling_type'] == "wholesale")
                    <a href="{{ url('user/quotationRequest/'.$productRequest['id']) }}"
                       class="btn btn-primary">{{trans('messages.quotation_request')}}</a>

                @endif
            @endif
        </div>
        <div class="col-md-8" style="background-color:#FFFFFF; padding:20px;">
            @if($productRequest->iwantto == "sale")
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        @if($productRequest->product1_file != "")
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        @endif
                        @if($productRequest->product2_file != "")
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        @endif
                        @if($productRequest->product3_file != "")
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                        @endif
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        @if($productRequest->product1_file != "")
                            <div class="item crop-height-slide active">
                                <a href="{{ url($productRequest->product1_file) }}" data-lightbox="products"
                                   data-title="{{ trans('validation.attributes.product1_file') }}">
                                    <img class="scale" src="{{ url($productRequest->product1_file) }}">
                                </a>
                                <div class="carousel-caption"></div>
                            </div>
                        @endif
                        @if($productRequest->product2_file != "")
                            <div class="item crop-height-slide">
                                <a href="{{ url($productRequest->product2_file) }}" data-lightbox="products"
                                   data-title="{{ trans('validation.attributes.product2_file') }}">
                                    <img class="scale" src="{{ url($productRequest->product2_file) }}">
                                </a>
                                <div class="carousel-caption"></div>
                            </div>
                        @endif
                        @if($productRequest->product3_file != "")
                            <div class="item crop-height-slide">
                                <a href="{{ url($productRequest->product3_file) }}" data-lightbox="products"
                                   data-title="{{ trans('validation.attributes.product3_file') }}">
                                    <img class="scale" src="{{ url($productRequest->product3_file) }}">
                                </a>
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
            {{ $productRequest->city }} {{ $productRequest->province }}
            <h3>{{ $productRequest->product_title }}</h3>
            <p>{!! $productRequest->product_description !!}</p>
            <h3>
                {{ trans('validation.attributes.price') }} :

                @if($productRequest->iwantto == "buy")
                    {{ floatval($productRequest->pricerange_start) }} - {{ floatval($productRequest->pricerange_end) }}
                @endif
                @if($productRequest->iwantto == "sale")
                    @if($productRequest->is_showprice)
                        {{ floatval($productRequest->price) }}
                    @endif
                    @if(!$productRequest->is_showprice)
                        {{ trans('messages.product_no_price') }}
                    @endif
                @endif
            </h3>
            <h3>
                {{ trans('validation.attributes.volumn') }} :
                @if($productRequest->iwantto == "buy")
                    {{ floatval($productRequest->volumnrange_start) }}
                    - {{ floatval($productRequest->volumnrange_end) }}  {{ $productRequest->units }}
                @endif
                @if($productRequest->iwantto == "sale")
                    {{ floatval($productRequest->volumn) }} {{ $productRequest->units }}
                @endif
            </h3>
        </div>
    </div>
    </div>
    <div class="row" style="margin-top: 15px;">
        <div class="col-lg-12">
            <link rel="stylesheet" href="{{url('font-awesome/css/font-awesome.min.css')}}">
            <link rel="stylesheet" href="{{url('css/star.css')}}">
            <link rel="stylesheet" href="{{url('css/comment.css')}}">
            @include('frontend.product_element.comment')
        </div>
    </div>
@stop
