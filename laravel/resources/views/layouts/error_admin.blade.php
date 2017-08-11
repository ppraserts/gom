<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    <link rel="stylesheet" href="{{ asset("assets/stylesheets/styles.css") }}" />
    <link rel="stylesheet" href="{{ asset("assets/stylesheets/bootstrap-tagsinput.css") }}" />
    <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
</head>
<body>
<div id="wrapper">
<?php
if (Lang::locale() == "th") {
    $enActive = "";
    $thActive = "active";
} else {
    $enActive = "active";
    $thActive = "";
}
$adminteam = auth()->guard('admin')->user();
?>
<!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand"
               href="{{ url ('/admin/productcategory') }}">{{ config('app.name', 'Laravel') }}</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown {{ $thActive }}">
                <a href="{{ url('/change/th') }}">
                    <img style="height: 20px;" src="{{url('/images/icon_th.png')}}" alt="Image"/>
                    {{ trans('messages.flag_th') }}
                </a>
                <!-- /.dropdown-messages -->
            </li>
            <!-- /.dropdown -->
            <li class="dropdown {{ $enActive }}">
                <a href="{{ url('/change/en') }}">
                    <img style="height: 20px;" src="{{url('/images/icon_en.png')}}" alt="Image"/>
                    {{ trans('messages.flag_en') }}
                </a>
                <!-- /.dropdown-tasks -->
            </li>
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="{{ url ('admin/userprofile') }}"><i
                                    class="fa fa-user fa-fw"></i> {{ trans('messages.userprofile') }}</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="{{ url ('admin/changepassword') }}"><i
                                    class="fa fa-key fa-fw"></i> {{ trans('messages.menu_changepassword') }}</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="{{ url ('/') }}"><i
                                    class="glyphicon glyphicon-home"></i> {{ trans('messages.menu_visit') }}</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="{{ url ('admin/logout') }}" onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();"><i
                                    class="fa fa-sign-out fa-fw"></i> {{ trans('messages.logout') }}</a>
                        <form id="logout-form" action="{{ url('admin/logout') }}" method="POST"
                              style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <!-- /.navbar-static-side -->
    </nav>
    @yield('content')
</div>
<!-- Scripts -->
<script src="{{ asset('/js/jquery-1.11.3.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="//maps.google.com/maps/api/js?key=AIzaSyCTyLJemFK5wu_ONI1iZobLGK9pP1EVReo"></script>
<script src="{{ asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
<script src="{{ asset('assets/scripts/frontend.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/scripts/bootstrap-tagsinput.js') }}" type="text/javascript"></script>
<script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
</body>
</html>
