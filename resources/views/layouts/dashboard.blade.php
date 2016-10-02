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
                <a class="navbar-brand" href="{{ url ('/admin/home') }}">{{ config('app.name', 'Laravel') }}</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a href="{{ url('/change/th') }}">
                        <img style="height: 20px;" src="{{url('/images/icon_th.png')}}" alt="Image"/>
                        TH
                    </a>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                  <a href="{{ url('/change/en') }}">
                      <img style="height: 20px;" src="{{url('/images/icon_en.png')}}" alt="Image"/>
                      EN
                  </a>
                    <!-- /.dropdown-tasks -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> {{ trans('messages.userprofile') }}</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{ url ('/logout') }}" onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-fw"></i> {{ trans('messages.logout') }}</a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
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
                        <li {{ (Request::is('*admin/productcategory*') ? 'class=active' : '') }}>
                            <a href="{{ url ('admin/productcategory') }}"><i class="glyphicon glyphicon-inbox fa-fw"></i> {{ trans('messages.menu_product_category') }}</a>
                        </li>
                        <li {{ (Request::is('*admin/slideimage*') ? 'class=active' : '') }}>
                            <a href="{{ url ('admin/slideimage') }}"><i class="glyphicon glyphicon-picture fa-fw"></i> {{ trans('messages.menu_slide_image') }}</a>
                        </li>
                        <li {{ (Request::is('*admin/downloaddocument*') ? 'class=active' : '') }}>
                            <a href="{{ url ('admin/downloaddocument') }}"><i class="glyphicon glyphicon-book fa-fw"></i> {{ trans('messages.menu_download_document') }}</a>
                        </li>
                        <li {{ (Request::is('*admin/aboutus*') ? 'class=active' : '') }}>
                            <a href="{{ url ('admin/aboutus') }}"><i class="glyphicon glyphicon-edit"></i> {{ trans('messages.menu_aboutus') }}</a>
                        </li>
                        <li {{ (Request::is('*admin/contactus*') ? 'class=active' : '') }}>
                            <a href="{{ url ('admin/contactus') }}"><i class="glyphicon glyphicon-edit"></i> {{ trans('messages.menu_contactus') }}</a>
                        </li>
                        <li {{ (Request::is('*admin/faq*') ? 'class=active' : '') }}>
                            <a href="{{ url ('admin/faqcategory') }}"><i class="glyphicon glyphicon-question-sign"></i> {{ trans('messages.menu_faq') }}</a>
                        </li>
                        <li {{ (Request::is('*admin/media*') ? 'class=active' : '') }}>
                            <a href="{{ url ('admin/media') }}"><i class="glyphicon glyphicon-facetime-video"></i> {{ trans('messages.menu_media') }}</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
			 <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">@yield('page_heading_image') @yield('page_heading')</h1>
                </div>
                <!-- /.col-lg-12 -->
           </div>
			<div class="row">
				@yield('section')

            </div>
            <!-- /#page-wrapper -->
        </div>
    </div>
@stop
