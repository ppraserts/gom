@extends('layouts.main')
@section('content')

<h3>
	<span class="glyphicon glyphicon-list-alt"></span> {{ $item->{ "news_title_".Lang::locale()} }}  
	( <span class="glyphicon glyphicon-tag">{{ $item->news_tags}}</span> )
</h3>
	
{!! $item->{"news_description_".Lang::locale()} !!}

<div class="row">
	<div class="col-md-3">
		<h4><span class="glyphicon glyphicon-map-marker"></span> {{ $item->news_place }}</h4>
	</div>
	<div class="col-md-3">
		<h4><span class="glyphicon glyphicon-bullhorn"></span> {{ $item->news_sponsor }}</h4>
	</div>
	<div class="col-md-3">
		<h4><span class="glyphicon glyphicon-calendar"></span> {{ $item->news_created_at }}</h4>
	</div>
	<div class="col-md-3">
		<h4>
		@if($item->news_document_file != "")
	        	<a href="{{ $item->news_document_file }}" target="_blank">
	        	@endif
		<span class="glyphicon glyphicon-save"></span> 
			{{ trans('messages.download') }}
		@if($item->news_document_file != "")
	          	</a>
	          	@endif
		</h4>
	</div>
</div>

@stop