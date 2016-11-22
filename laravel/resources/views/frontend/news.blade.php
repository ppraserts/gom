@extends('layouts.main')
@section('content')
<div class="row">
	<div class="col-md-6">
	<h3>{{ trans('messages.menu_imageactivity') }}</h3>
	@if(count($slideItem)>0)
	 <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
	      <!-- Indicators -->
	      <ol class="carousel-indicators">
	        <?php
	        	$index = 0;
	        	foreach ($slideItem as $slide)
	        	{
	        ?>
	          <li data-target="#carousel-example-generic" data-slide-to="{{ $index }}" class="{{ $index==0? 'active' : '' }}"></li>
	        <?php
	        		$index++;
	        	}
	        ?>
	      </ol>

	      <!-- Wrapper for slides -->
	      <div class="carousel-inner" role="listbox">
	        <?php
	        	$index = 0;
	        	foreach ($slideItem as $slide)
	        	{
	        ?>
	        <div class="item {{ $index==0? 'active' : '' }}">
	        	@if($slide->slideimage_urllink != "")
	        	<a href="{{ $slide->slideimage_urllink }}" target="_blank">
	        	@endif
	          	<img src="{{ url($slide->slideimage_file) }}" style="width:100%;" >
	          	@if($slide->slideimage_urllink != "")
	          	</a>
	          	@endif
	          <div class="carousel-caption"></div>
	        </div>
	        <?php
	        		$index++;
	        	}
	        ?>
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
	@endif
	</div>
	<div class="col-md-6">
		<h3>{{ trans('messages.menu_media') }}</h3>
		@if(count($mediaItem)>0)
			 <div id="carousel-example-generic2" class="carousel slide" data-ride="carousel">
			      <!-- Indicators -->
			      <ol class="carousel-indicators">
			        <?php
			        	$index = 0;
			        	foreach ($mediaItem as $media)
			        	{
			        ?>
			          <li data-target="#carousel-example-generic2" data-slide-to="{{ $index }}" class="{{ $index==0? 'active' : '' }}"></li>
			        <?php
			        		$index++;
			        	}
			        ?>
			      </ol>

			      <!-- Wrapper for slides -->
			      <div class="carousel-inner" role="listbox">
			        <?php
			        	$index = 0;
			        	foreach ($mediaItem as $media)
			        	{
			        ?>
			        <div class="item {{ $index==0? 'active' : '' }}">
			          	<div class="embed-responsive embed-responsive-16by9">
			              <iframe class="embed-responsive-item" src="{{ $media->media_urllink }}"></iframe>
			            </div>
			          <div class="carousel-caption"></div>
			        </div>
			        <?php
			        		$index++;
			        	}
			        ?>
			      </div>

			      <!-- Controls -->
			      <a class="left carousel-control" href="#carousel-example-generic2" role="button" data-slide="prev">
			        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			        <span class="sr-only">Previous</span>
			      </a>
			      <a class="right carousel-control" href="#carousel-example-generic2" role="button" data-slide="next">
			        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			        <span class="sr-only">Next</span>
			      </a>
			    </div>
		@endif
	</div>
</div>

<h3>{{ trans('messages.menu_news') }}</h3>
@foreach ($newsItem as $news)
	<a href="{{ url('news/'.$news->id) }}">
	<span class="glyphicon glyphicon-list-alt"></span> {{ $news->{"news_title_".Lang::locale()} }} - {{ $news->news_created_at }}
</a><br/>
@endforeach
<br/>
<br/>
<h3>{{ trans('messages.menu_download_document') }}</h3>
@foreach ($downloadDocumentitem as $downloaddocument)
	<a href="{{ url($downloaddocument->downloaddocument_file) }}">
	<span class="glyphicon glyphicon-list-alt"></span> {{ $downloaddocument->{"downloaddocument_title_".Lang::locale()} }}
	</a><br/>
@endforeach
<br/>
<br/>
<h3>{{ trans('messages.menu_aboutus') }}</h3>
{!! $aboutusItem->{"aboutus_description_".Lang::locale()} !!}

@foreach ($bannerItem as $banner)
@if($banner->slideimage_urllink != "")
<a href="{{ $banner->slideimage_urllink }}" target="_blank">
@endif
<img style="width:165px; height:56px;" src="{{ url($banner->slideimage_file) }}" >
@if($banner->slideimage_urllink != "")
</a>
@endif
@endforeach

 @stop
