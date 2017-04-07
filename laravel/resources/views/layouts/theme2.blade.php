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
    <link href="/assets/theme/css/theme2_style.css" rel="stylesheet">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>


    <link href="https://fonts.googleapis.com/css?family=Kanit:100,200,300,400,500,600|Lato:100,300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Trirong:400,500,600,700" rel="stylesheet">

</head>
<?php
if ($shop != null && isset($shop->image_file_2)) {
    $image_header = $shop->image_file_2;
} else {
    $image_header = 'assets/theme/images/header-2.jpg)';
}
?>
<body class="theme theme-section theme-section-two">

<header class="header header-image header-theme-two" style="background: url({{$image_header}}) no-repeat center center scroll; background-size: cover;">
    <div class="text-vertical-center">
        <img class="img-header-shadow img-responsive" src="assets/theme/images/shadow.png">
        <div class="headline">
            <div class="container">
                <div class="headline-detail">
                    <h2>Welcome to <span>{{$shop->shop_name}} </span>Farm</h2>
                    <h1>{{$shop->shop_title}}</h1>
                    <p>{{$shop->shop_description}}</p>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="promotions">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="promotion-item">
                                    <a href="#">
                                        <img class="img-promotion img-responsive" src="assets/theme/images/theme-two_01.jpg">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="promotion-item">
                                    <a href="#">
                                        <img class="img-promotion img-responsive" src="assets/theme/images/theme-two_02.jpg">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="promotion-item">
                                    <a href="#">
                                        <img class="img-promotion img-responsive" src="assets/theme/images/theme-two_04.jpg">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="promotion-item">
                            <a href="#">
                                <img class="img-promotion img-responsive" src="assets/theme/images/theme-two_03.jpg">
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
                <div class="row">
                    <ul>
                        <li class="active"><a href="#">All</a></li>
                        <li><a href="#">Vegetables</a></li>
                        <li><a href="#">Fruits</a></li>
                        <li><a href="#">Discount</a></li>
                        <li><a href="#">Seasonal</a></li>
                    </ul>

                    <div class="row">
                    @if($products != null)
                            @foreach($products as $product)
                                <div class="col-md-3 col-sm-6">
                                    <div class="products-item">
                                        <div class="thumbnail">
                                            <div class="product-image">
                                                <img class="img-product img-responsive" src="{{asset($product->product1_file)}}" alt="">
                                                <div class="product-price">
                                                    {{$product->price}}
                                                </div>
                                            </div>
                                            <div class="product-detail">
                                                <div class="product-title">
                                                    <a href="#"><h4>  {{$product->product_title}}</h4></a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                    @endif
                    </div>
                </div>
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
            <div class="col-lg-8">
                <div class="contact-map">
                    <iframe width="100%" height="326px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;aq=0&amp;oq=twitter&amp;sll=28.659344,-81.187888&amp;sspn=0.128789,0.264187&amp;ie=UTF8&amp;hq=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;t=m&amp;z=15&amp;iwloc=A&amp;output=embed"></iframe>
                    <br />
                    <small>
                        <a href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;aq=0&amp;oq=twitter&amp;sll=28.659344,-81.187888&amp;sspn=0.128789,0.264187&amp;ie=UTF8&amp;hq=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;t=m&amp;z=15&amp;iwloc=A"></a>
                    </small>
                </div>
            </div>
            <div class="col-lg-4">
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
