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
@extends('layouts.plane')
@section('body')
    <div id="wrapper">

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

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        @if(strpos($adminteam->allow_menu, 'menu_user') !== false||$adminteam->is_superadmin)
                            <li {{ (Request::is('*admin/users*') ? 'class=active' : '') }}>
                                <a href="{{ url ('admin/users') }}"><i
                                            class="fa fa-user fa-fw"></i> {{ trans('messages.menu_user') }}</a>
                            </li>
                        @endif
                        @if(strpos($adminteam->allow_menu, 'menu_market') !== false||$adminteam->is_superadmin)
                            <li {{ (Request::is('*admin/market*') ? 'class=active' : '') }}>
                                <a href="{{ url ('admin/market') }}"><i
                                            class="glyphicon glyphicon-shopping-cart"></i> {{ trans('messages.menu_market') }}
                                </a>
                            </li>
                        @endif
                        @if(strpos($adminteam->allow_menu, 'menu_product_category') !== false||$adminteam->is_superadmin)
                            <li {{ (Request::is('*admin/product*') ? 'class=active' : '') }}>
                                <a href="{{ url ('admin/productcategory') }}"><i
                                            class="glyphicon glyphicon-inbox fa-fw"></i> {{ trans('messages.menu_product_category') }}
                                </a>
                            </li>
                        @endif
                        @if(strpos($adminteam->allow_menu, 'menu_slide_image') !== false||$adminteam->is_superadmin)
                            <li {{ (Request::is('*admin/slideimage*') ? 'class=active' : '') }}>
                                <a href="{{ url ('admin/slideimage') }}"><i
                                            class="glyphicon glyphicon-picture fa-fw"></i> {{ trans('messages.menu_slide_image') }}
                                </a>
                            </li>
                        @endif
                        @if(strpos($adminteam->allow_menu, 'menu_download_document') !== false||$adminteam->is_superadmin)
                            <li {{ (Request::is('*admin/downloaddocument*') ? 'class=active' : '') }}>
                                <a href="{{ url ('admin/downloaddocument') }}"><i
                                            class="glyphicon glyphicon-book fa-fw"></i> {{ trans('messages.menu_download_document') }}
                                </a>
                            </li>
                        @endif
                        @if(strpos($adminteam->allow_menu, 'menu_bad_word') !== false||$adminteam->is_superadmin)
                            <li {{ (Request::is('*admin/badword*') ? 'class=active' : '') }}>
                                <a href="{{ url ('admin/badword') }}"><i
                                            class="glyphicon glyphicon-ban-circle fa-fw"></i> {{ trans('messages.menu_bad_word') }}
                                </a>
                            </li>
                        @endif
                        @if(strpos($adminteam->allow_menu, 'menu_aboutus') !== false||$adminteam->is_superadmin)
                            <li {{ (Request::is('*admin/aboutus*') ? 'class=active' : '') }}>
                                <a href="{{ url ('admin/aboutus') }}"><i
                                            class="glyphicon glyphicon-edit"></i> {{ trans('messages.menu_aboutus') }}
                                </a>
                            </li>
                        @endif
                        @if(strpos($adminteam->allow_menu, 'menu_contactus') !== false||$adminteam->is_superadmin)
                            <li {{ (Request::is('*admin/contactus*') ? 'class=active' : '') }}>
                                <a href="{{ url ('admin/contactus') }}"><i
                                            class="glyphicon glyphicon-edit"></i> {{ trans('messages.menu_contactus') }}
                                </a>
                            </li>
                        @endif
                        @if(strpos($adminteam->allow_menu, 'menu_faq') !== false||$adminteam->is_superadmin)
                            <li {{ (Request::is('*admin/faq*') ? 'class=active' : '') }}>
                                <a href="{{ url ('admin/faqcategory') }}"><i
                                            class="glyphicon glyphicon-question-sign"></i> {{ trans('messages.menu_faq') }}
                                </a>
                            </li>
                        @endif
                        @if(strpos($adminteam->allow_menu, 'menu_media') !== false||$adminteam->is_superadmin)
                            <li {{ (Request::is('*admin/media*') ? 'class=active' : '') }}>
                                <a href="{{ url ('admin/media') }}"><i
                                            class="glyphicon glyphicon-facetime-video"></i> {{ trans('messages.menu_media') }}
                                </a>
                            </li>
                        @endif
                        @if(strpos($adminteam->allow_menu, 'menu_news') !== false||$adminteam->is_superadmin)
                            <li {{ (Request::is('*admin/news*') ? 'class=active' : '') }}>
                                <a href="{{ url ('admin/news') }}"><i
                                            class="glyphicon glyphicon-bullhorn"></i> {{ trans('messages.menu_news') }}
                                </a>
                            </li>
                        @endif
                        @if(strpos($adminteam->allow_menu, 'menu_report') !== false||$adminteam->is_superadmin)
                            <li {{ (Request::is('*admin/report*') ? 'class=active' : '') }}>
                                <a href="{{ url ('admin/reports/buy') }}"><i
                                            class="glyphicon glyphicon-stats"></i> {{ trans('messages.menu_report') }}
                                </a>
                            </li>
                        @endif
                        @if($adminteam->is_superadmin)
                            <li {{ (Request::is('*admin/admin*') ? 'class=active' : '') }}>
                                <a href="{{ url ('admin/adminteam') }}"><i
                                            class="glyphicon glyphicon-user"></i> {{ trans('messages.menu_adminteam') }}
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                @if(Request::segment(2) != 'reports')
                <div class="col-lg-12">
                    <h1 class="page-header">@yield('page_heading_image') @yield('page_heading')</h1>
                </div>
                @endif
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                @yield('section')

            </div>
            <!-- /#page-wrapper -->
        </div>
    </div>
@stop
