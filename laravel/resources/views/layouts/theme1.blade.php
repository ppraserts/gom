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
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/assets/theme/css/theme1_style.css" rel="stylesheet">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

</head>

<body class="theme theme-section theme-section-one">


<?php

$shop_name = session('shop')['shop_name'];

if ($shop != null && isset($shop->image_file_1)) {
    $image_header = $shop->image_file_1;
} else {
    $image_header = $shop_name.'/assets/theme/images/header-1.jpg)';
}
?>


<header class="header header-image header-theme-one" style="background: url({{asset($image_header)}}) no-repeat center center scroll; background-size: cover;">
    <div class="text-vertical-center">
        <div class="headline">
            <div class="container">
                <h2>Welcome to <span>{{$shop->shop_name}} </span>Farm</h2>
                <h1>{{$shop->shop_title}}</h1>
                <p>{{$shop->shop_description}}</p>
            </div>
        </div>
    </div>
</header>

<section class="promotions">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="row">
                    <div class="col-md-6">
                        <div class="promotion-item">
                            <a href="#">
                                <img class="img-promotion img-responsive" src="{{asset("assets/theme/images/theme-one_01.jpg")}}">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="promotion-item">
                            <a href="#">
                                <img class="img-promotion img-responsive" src="{{asset('assets/theme/images/theme-one_02.jpg')}}">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="promotion-item">
                                    <a href="#">
                                        <img class="img-promotion img-responsive" src="assets/theme/images/theme-one_03.jpg">
                                    </a>
                                </div>
                                <div class="promotion-item">
                                    <a href="#">
                                        <img class="img-promotion img-responsive" src="assets/theme/images/theme-one_05.jpg">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="promotion-item">
                                    <a href="#">
                                        <img class="img-promotion img-responsive" src="assets/theme/images/theme-one_04.jpg">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="promotion-item">
                            <a href="#">
                                <img class="img-promotion img-responsive" src="assets/theme/images/theme-one_06.jpg">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="products">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-12">
                <h2>best sellers</h2>
                <hr class="small">
                {{--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer adipiscing erat eget risus <br> sollicitudin pellentesque et non erat. Maecenas nibh dolor, malesuada et bibendum</p>--}}
                @yield('product')
            </div>
        </div>
    </div>
</section>

<section class="contact">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-12">
                <h2>Gets In Touch</h2>
                <hr class="small">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7">
                <div class="contact-map">
                    <iframe width="100%" height="326px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                            src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;aq=0&amp;oq=twitter&amp;sll=28.659344,-81.187888&amp;sspn=0.128789,0.264187&amp;ie=UTF8&amp;hq=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;t=m&amp;z=15&amp;iwloc=A&amp;output=embed"></iframe>
                    <br/>
                    <small>
                        <a href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;aq=0&amp;oq=twitter&amp;sll=28.659344,-81.187888&amp;sspn=0.128789,0.264187&amp;ie=UTF8&amp;hq=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;t=m&amp;z=15&amp;iwloc=A"></a>
                    </small>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="contact-detail">
                    <h3>Contact Infos</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                    <p><strong>Company Name Inc.</strong></p>
                    <p>300 Princess Road London,</p>
                    <p>Greater London,United Kingdom</p>
                    <p><a href="tel:+44123456789">+44 123456789</a></p>
                    <p><a href="mailto:suport@dgtfarm.com">suport@dgtfarm.com</a></p>
                    <p><a href="#">www.dgtfarm.com</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="comments">
    <div class="container">
        <div class="row">
            <div class="col-lg-12"></div>
        </div>
    </div>
</section>

</body>

</html>
