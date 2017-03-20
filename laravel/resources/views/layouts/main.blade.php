<?php
        if(Lang::locale() == "th")
        {
          $enActive = "";
          $thActive = "active";
        }
        else {
          $enActive = "active";
          $thActive = "";
        }


       $user = auth()->guard('user')->user();
       $linkProfile = "/user/userprofiles";

?>
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
        <link href="/css/bootstrap.min.css" rel="stylesheet">
		<link href="/css/typeaheadjs.css" rel="stylesheet">
        <link href="/css/bootstrap-datepicker.standalone.min.css" rel="stylesheet">
        <link href="/css/custom.css" rel="stylesheet">
        <link href="/fonts/css/font-awesome.min.css" rel="stylesheet">
		<link href="/css/lightbox.min.css" rel="stylesheet">
        <link href="{{ captcha_layout_stylesheet_url() }}" type="text/css" rel="stylesheet">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
        <!-- Scripts -->
        <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
        </script>
    </head>

    <body>
        <!--/.nav-->
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url('/') }}">Greenmart Online Market</a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="langBox">
                            <a href="{{ url('/change/th') }}" class="{{ $thActive }}"><img src="{{ url('images/thai-flag.png') }}" alt=""> {{ trans('messages.flag_th') }}</a>
                        </li>
                        <li class="langBox">
                            <a href="{{ url('/change/en') }}" class="{{ $enActive }}"><img src="{{ url('images/eng-flag.png') }}" alt=""> {{ trans('messages.flag_en') }}</a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">{{ trans('messages.menu_visit') }} <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('/') }}" title="{{ trans('messages.menu_index') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>  {{ trans('messages.menu_travel') }}</a></li>
                                <li role="separator" class="divider"></li>
                                @if($user!=null)
                                  <li><a href="{{ $linkProfile }}" title="{{ trans('messages.menu_manageprofile') }}"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>  {{ trans('messages.menu_manageshop') }}</a></li>
                                  <li role="separator" class="divider"></li>
                                  <li><a href="{{ url('user/matchings') }}"><span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span>  {{ trans('messages.menu_matching') }}</a></li>
                                  <li role="separator" class="divider"></li>
                                @endif
                                <li><a href="{{ url('/news') }}"><span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span>  {{ trans('messages.menu_announcement') }}</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="{{ url('/faq') }}"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>   {{ trans('messages.menu_faq') }}</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="{{ url('/contactus') }}"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>  {{ trans('messages.menu_contactus') }}</a></li>
                                <li role="separator" class="divider"></li>
                                 <li><a href="{{ url('/sitemap') }}"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>  {{ trans('messages.sitemap') }}</a></li>
                            </ul>
                        </li>
                        @if($user == null)
                                <li>
                                        <a href="{{ url('/user/login') }}" title="{{ trans('messages.menu_login') }}"><span class="glyphicon glyphicon-user"></span>  {{ trans('messages.menu_loginmarket') }}</a>
                                </li>
                        @endif
                        <li>
                            <div class="btn-nav">
                                        @if($user != null)
                                                    <a href="{{ url('/user/logout') }}"
                                                    onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();"  class="btn btn-danger btn-small navbar-btn">
                                                    {{ trans('messages.logout') }}
                                                </a>

                                                <form id="logout-form" action="{{ url('/user/logout') }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>
                                        @else
                                                    <a title="{{ trans('messages.menu_register') }}" class="btn btn-success btn-small navbar-btn" href="{{ url('/user/chooseregister') }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> {{ trans('messages.menu_openshop') }}</a>
                                        @endif
                                </div>
                        </li>
                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </nav>
        <!--/.nav-->
        <div class="container">
            <div class="starter-template">
                @yield('content')
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <p class="text-muted">{{ trans('messages.copyright') }}</p>
            </div>
        </footer>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="/js/jquery-1.11.3.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/typeahead.bundle.min.js"></script>
        <script src="/js/bootstrap-datepicker.min.js"></script>
        <script src="/js/bootstrap-datepicker-thai.js"></script>
		<script src="/js/bootstrap-datepicker.th.min.js"></script>	
		<script src="/js/typeahead.bundle.min.js"></script>
        <script src="/js/jssor.slider.mini.js"></script>
		<script src="/js/lightbox.min.js"></script>
		<script>
			lightbox.option({
				'resizeDuration': 0,
				'wrapAround': true,
				'albumLabel': '{{ Lang::get('validation.attributes.slideimage_name') }} %1 / %2'
			})
		</script>
        @stack('scripts')
    </body>

    </html>
