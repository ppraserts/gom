<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Bootstrap -->
    <link href="{{asset('/css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/theme/css/theme1_style.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/theme/css/base_theme.css')}}" rel="stylesheet">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>



</head>

<body class="theme theme-section theme-section-one">


<?php

if ($shop != null && $shop->image_file_1 != '') {
    $image_header = $shop->image_file_1;
} else {
    $image_header = 'assets/theme/images/header-1.jpg';
}
?>


<div class="container">
    <header class="header header-image header-theme-one" style="background: url({{asset($image_header)}}); background-size: cover; max-height: 560px; height: 560px;">
        @yield('header')
    </header>
    @yield('promotion')

    <section class="products">
        <div class="row text-center">
            <div class="col-lg-12">
                <h2>{{ trans('messages.shop_product') }}</h2>
                <hr class="small">
                {{--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer adipiscing erat eget risus <br> sollicitudin pellentesque et non erat. Maecenas nibh dolor, malesuada et bibendum</p>--}}
                @yield('product')
            </div>
        </div>
    </section>

    <section class="contact">
        <div class="row text-center">
            <div class="col-lg-12">
                <h2>{{ trans('messages.menu_contactusinfo') }}</h2>
                <hr class="small">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7">
                <div class="contact-map">
                    <iframe width="100%" height="326px" frameborder="0" scrolling="no" marginheight="0"
                            marginwidth="0"
                            src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q={{ $shop->user->users_latitude }},{{$shop->user->users_longitude}}&amp;aq=0&amp;ie=UTF8&amp;t=m&amp;z=15&amp;iwloc=A&amp;output=embed"></iframe>
                    <br/>
                    <small>
                        <a href="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q={{ $shop->user->users_latitude }},{{$shop->user->users_longitude}}&amp;aq=0&amp;ie=UTF8&amp;t=m&amp;z=15&amp;iwloc=A&amp;output=embed""></a>
                    </small>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="contact-detail">
                    <h3>{{ trans('messages.menu_contactusinfo') }}</h3>
                    <p><strong>{{ $shop->user->users_firstname_th. " ". $shop->user->users_lastname_th}}</strong>
                    </p>
                    <p>{{$shop->user->users_addressname . " " . $shop->user->users_street}}</p>
                    <p>{{$shop->user->users_district . " " . $shop->user->users_city}}</p>
                    <p>{{$shop->user->users_province. " ".$shop->user->users_postcode}} </p>
                    @if(isset($shop->user->users_mobilephone))
                        <p>
                            <a href="tel:{{$shop->user->users_mobilephone}}">
                                {{$shop->user->users_mobilephone}}
                            </a>
                        </p>
                    @endif
                    @if(isset($shop->user->users_phone))
                        <p>
                            <a href="tel:{{$shop->user->users_phone}}">
                                {{$shop->user->users_phone}}
                            </a>
                        </p>
                    @endif
                    @if(isset($shop->user->email))
                        <p>
                            <a href="mailto:{{$shop->user->email}}">{{$shop->user->email}}</a>
                        </p>
                    @endif
                </div>
            </div>
        </div>

    </section>

    <section class="comments">
        <div class="row">
            <div class="col-lg-12">
                <link rel="stylesheet" href="{{url('font-awesome/css/font-awesome.min.css')}}">
                <link rel="stylesheet" href="{{url('css/star.css')}}">
                <link rel="stylesheet" href="{{url('css/comment.css')}}">
                @include('frontend.shop_element.comment')
            </div>
        </div>
    </section>
</div>
<link href="{{url('jquery-loading/waitMe.css')}}" rel="stylesheet">
<script src="{{url('jquery-loading/waitMe.js')}}"></script>
@stack('scripts')
</body>

</html>
