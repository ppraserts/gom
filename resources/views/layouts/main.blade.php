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
	  <link href="/css/Base.css" rel="stylesheet">

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
  <header>
	<nav class="navbar navbar-default">
  <div class="container-fluid">
  <div class="row">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><img src="images/logo.png" alt=""></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<div class="row rightSideArea">
			<div class="rightSide col-xs-12 col-sm-8 col-md-8">
			<div class="signUpBox">
				<button type="button" class="btn btn-default btn-block loginBtn">เข้าสู่ระบบ</button>
				<button type="button" class="btn btn-primary btn-block signUpBtn">สมัครสมาชิก</button>
			</div>
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
      ?>
			<ul class="langBox">
				<li><a href="{{ url('/change/en') }}" class="flag flagEng  {{ $enActive }}"><img src="images/eng-flag.png" alt="">Eng</a></li>
				<li><a href="{{ url('/change/th') }}" class="flag flagThai {{ $thActive }}"><img src="images/thai-flag.png" alt="">ไทย</a></li>
			</ul>
			</div>
		</div>
	<div class="row menuArea">
	<div class="col-xs-12">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">หน้าหลัก <span class="sr-only">(current)</span></a></li>
        <li><a href="#">ข้อมูลส่วนตัว</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Matching <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">One more separated link</a></li>
          </ul>
        </li>
		 <li><a href="#">ค้นหา</a></li>
		 <li><a href="#">FAQ</a></li>
		 <li><a href="#">ดาวโหลด</a></li>
		 <li><a href="#">ติดต่อเรา</a></li>
		 <li><a href="/login">Management</a></li>
      </ul>
	  </div>
	</div>
    </div><!-- /.navbar-collapse -->
	</div>
  </div><!-- /.container-fluid -->
</nav>
 </header>
  <main>
  <div class="container-fluid">
  <div class="row">
    <div id="carousel-example-generic" class="carousel slide slideShowMain" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    @foreach ($slideItem as $key => $item)
      <li data-target="#carousel-example-generic" data-slide-to="{{ $key }}" class="{{ ($key==0)? 'active' : '' }}"></li>
    @endforeach
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    @foreach ($slideItem as $key => $item)
    <div class="item {{ ($key==0)? 'active' : '' }}">
      <img src="{{ $item->slideimage_file }}" alt="">
    </div>
    @endforeach
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
  </div>
  <div class="row searchArea">
  <div class="container">
  <div class="col-xs-12">
  <div class="row">
	<div class="searchBox">
		<h2>ยินดีต้อนรับ</h2>
		<div class="lineBottom"></div>
		<form >
		  <div class="col-xs-12 col-sm-12 col-md-6">
		  <div class="form-group">
			<input type="text" class="form-control" id="exampleInputEmail3" placeholder="Watch">
		  </div>
		  </div>
		  <div class="col-xs-12 col-sm-12 col-md-4">
		  <div class="form-group">
		  <select class="form-control">
			  <option>All Categories</option>
        @foreach ($productCategoryitem as $key => $item)
			     <option value="{{ $item->id }}">{{ $item->{ "productcategory_title_".Lang::locale()} }}</option>
        @endforeach
			</select>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-2 btnArea">
		<div class="searchBtn">
		<button type="submit" class="btn btn-primary btn-block">ค้นหา</button>
		</div>
		</div>
		</form>
	</div>
	</div>
	</div>
	</div>
  </div>
  <div class="row newsContainer">
  <div class="container">
  <div class="col-xs-12">
	<div class="col-xs-12 col-md-6">
	<div class="row"><h3>News & Update</h3></div>
	<div class="row newsBox">
		<div class="col-xs-12 col-md-2 dateBox">
		<p><span class="titleDate">21 </span><span> กรกฏาคม </span><span>2016</span></p>
		</div>
		<div class="col-xs-12 col-md-10 detailBox">
		<p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua....</p>
		</div>
	</div>
	<div class="row newsBox">
		<div class="col-xs-12 col-md-2 dateBox">
		<p><span class="titleDate">21 </span><span> กรกฏาคม </span><span>2016</span></p>
		</div>
		<div class="col-xs-12 col-md-10 detailBox">
		<p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua....</p>
		</div>
	</div>
	<a href="#" class="viewAll">View All ></a>
	</div>
	<div class="col-xs-12 col-md-6">
	<h3>Media</h3>
	<div id="carousel-example-generic2" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    @foreach ($mediaItem as $key => $item)
    <li data-target="#carousel-example-generic" data-slide-to="{{ $key }}" class="{{ ($key==0)? 'active' : '' }}"></li>
    @endforeach
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    @foreach ($mediaItem as $key => $item)
    <div class="item {{ ($key==0)? 'active' : '' }}">
      <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="{{ $item->media_urllink }}"></iframe>
      </div>
    </div>
    @endforeach
  </div>
</div>
	</div>
  </div>
  </div>
  </div>
  <div class="row">
  <div class="container">
	<div class="col-xs-12">
	<h2>สินค้าขายดี</h2>
	<div class="lineBottom"></div>
	<div class="col-xs-12">
	<div class="row">
		<div class="col-xs-12 col-sm-4 col-md-4">
			<div class="thumbnail thumbnail1">
			  <img src="images/thumbnail1.png" alt="">
			  <div class="caption">
				<h3 class="noCaption">1</h3>
				<h3 class="title">Lorem ipsum</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do aliqua</p>
				<p class="viewAllLink"><a href="#">View All ></a></p>
			  </div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-4">
			<div class="thumbnail thumbnail2">
			  <img src="images/thumbnail1.png" alt="">
			  <div class="caption">
				<h3 class="noCaption">2</h3>
				<h3>Lorem ipsum</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do aliqua</p>
				<p class="viewAllLink"><a href="#">View All ></a></p>
			  </div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-4">
			<div class="thumbnail thumbnail3">
			  <img src="images/thumbnail1.png" alt="">
			  <div class="caption">
				<h3 class="noCaption">3</h3>
				<h3>Lorem ipsum</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do aliqua</p>
				<p class="viewAllLink"><a href="#">View All ></a></p>
			  </div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-4">
			<div class="thumbnail thumbnail4">
			  <img src="images/thumbnail1.png" alt="">
			  <div class="caption">
				<h3 class="noCaption">4</h3>
				<h3>Lorem ipsum</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do aliqua</p>
				<p class="viewAllLink"><a href="#">View All ></a></p>
			  </div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-4">
			<div class="thumbnail thumbnail5">
			  <img src="images/thumbnail1.png" alt="">
			  <div class="caption">
				<h3 class="noCaption">5</h3>
				<h3>Lorem ipsum</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do aliqua</p>
				<p class="viewAllLink"><a href="#">View All ></a></p>
			  </div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-4">
			<div class="overlayBG"></div>
			<div class="thumbnail thumbnail5">
			  <img src="images/thumbnail1.png" alt="">
			  <div class="caption">
				<h3 class="noCaption">5</h3>
				<h3>Lorem ipsum</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do aliqua</p>
				<p class="viewAllLink"><a href="#">View All ></a></p>
			  </div>
			</div>
		</div>
	</div>
	</div>
	</div>
	</div>
  </div>
  <div class="row featureArea">
	<div class="col-xs-12">
		<div class="row feature">
			<div class="col-xs-12 col-sm-12 col-md-6 text-center">
				<img src="images/detail-img.png" alt="" class="featurette-image img-responsive">
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <h2>Business Maching</h2>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into </p>
				<p><button type="submit" class="btn btn-primary btn-block">Read more</button></p>
			</div>
        </div>
		<div class="row feature">
		        <div class="col-xs-12 col-sm-12 col-md-6 text-center">
				<img src="images/detail-img2.png" alt="" class="featurette-image img-responsive">
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <h2>Business Maching</h2>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into </p>
				<p><button type="submit" class="btn btn-primary btn-block">Read more</button></p>
			</div>
        </div>
		 </div>
		</div>
  <div class="row centerContent">
			<div class="col-xs-12">
			<h2>{{ trans('messages.menu_aboutus') }}</h2>
      {!! $aboutusItem->{ "aboutus_description_".Lang::locale()} !!}
			</div>
			<div class="col-xs-12">
			<div class="slidesBannerArea">
			<div class="slidesBanner">
				<div class="itemBanner">
            @foreach ($bannerItem as $key => $item)
              <a href="{{ $item->slideimage_urllink }}" target="_blank">
                <img src="{{ $item->slideimage_file }}" alt="" class="itemImg">
              </a>
            @endforeach
        </div>
			</div>
				 <a class="left carousel-control" href="#" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				  </a>
				  <a class="right carousel-control" href="#" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				  </a>
			</div>
			</div>
   </div>
  </div>
  </main>
  <footer class="footer">
    <div class="container">
  <div class="row">
  <div class="col-xs-12">
	<p>Copyright © 2016. All Rights Reserved. </p>
	</div>
	</div>
	</div>
  </footer>
    @yield('content')

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/js/jquery-1.11.3.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/jssor.slider.mini.js"></script>
    <script>
        jQuery(document).ready(function ($) {
            //var options = { $AutoPlay: true };
            //var jssor_slider1 = new $JssorSlider$('slider1_container', options);
        });
    </script>
  </body>
</html>
