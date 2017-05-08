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
    <link href="{{URL::asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/theme/css/theme2_style.css')}}" rel="stylesheet">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>


    <link href="https://fonts.googleapis.com/css?family=Kanit:100,200,300,400,500,600|Lato:100,300,400,700"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Trirong:400,500,600,700" rel="stylesheet">

</head>
<?php
$shop_name = $shop->shop_name;
if ($shop != null && isset($shop->image_file_2)) {
    $image_header = $shop->image_file_2;
} else {
    $image_header = 'assets/theme/images/header-2.jpg)';
}
?>
<body class="theme theme-section theme-section-two">

<header class="header header-image header-theme-two"
        style="background: url({{$image_header}}) no-repeat center center scroll; background-size: cover;">
    <div class="text-vertical-center">
        <img class="img-header-shadow img-responsive" src="assets/theme/images/shadow.png">
        <div class="headline">
            <div class="container">
                <div class="headline-detail">
                    <h2>{{$shop->shop_subtitle}}</h2>
                    <h1>{{$shop->shop_title}}</h1>
                    <p>{{$shop->shop_description}}</p>
                </div>
            </div>
        </div>
    </div>
</header>
@if(count($promotions) > 0 )
    <section class="promotions">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="row">
                        @foreach($promotions as $promotion)
                            <div class="col-md-4">
                                <div class="promotion-item">
                                    <a href="{{$shop_name."/promotion/".$promotion->id}}" title="{{$promotion->promotion_title}}">
                                        @if(isset($promotion->image_file))
                                            <img class="img-promotion img-responsive" src="{{url( $promotion->image_file)}}">
                                            <p style="padding-top: 10px;">
                                                <?php $p =''; if(strlen($promotion->promotion_title) > 48){ $p = '...'; }?>
                                                {{ iconv_substr(strip_tags($promotion->promotion_title), 0, 48, "UTF-8").$p}}
                                            </p>
                                        @endif
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
<section class="products">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-12">
                <h2>{{ trans('messages.shop_product') }}</h2>
                <div class="row">

                    <div class="row">
                        @yield('product')
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
                <h2>{{ trans('messages.menu_contactusinfo') }}</h2>
                <hr class="small">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="contact-map">
                    <iframe width="100%" height="326px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                            src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=13.852896,100.574899&amp;aq=0&amp;ie=UTF8&amp;t=m&amp;z=15&amp;iwloc=A&amp;output=embed"
                    "></iframe>
                    <br/>
                    <small>
                        <a href="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=13.852896,100.574899&amp;aq=0&amp;ie=UTF8&amp;t=m&amp;z=15&amp;iwloc=A&amp;output=embed""></a>
                    </small>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="contact-detail">
                    <h3>{{ trans('messages.menu_contactusinfo') }}</h3>
                    <p><strong>{{ $shop->user->users_firstname_th. " ". $shop->user->users_lastname_th}}</strong></p>
                    <p>{{$shop->user->users_addressname . " " . $shop->user->users_street}}</p>
                    <p>{{$shop->user->users_district . " " . $shop->user->users_city}}</p>
                    <p>{{$shop->user->users_province. " ".$shop->user->users_postcode}} </p>
                    @if(isset($shop->user->users_mobilephone))<p><a
                                href="tel:{{$shop->user->users_mobilephone}}">{{$shop->user->users_mobilephone}}</a>
                    </p>@endif
                    @if(isset($shop->user->users_phone))<p><a
                                href="tel:{{$shop->user->users_phone}}">{{$shop->user->users_phone}}</a></p>@endif
                    @if(isset($shop->user->email))<p><a href="mailto:{{$shop->user->email}}">{{$shop->user->email}}</a>
                    </p>@endif
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
