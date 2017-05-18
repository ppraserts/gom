<?php
use App\Http\Controllers\frontend\MarketController;

$url = "user/iwanttobuy";
?>
@extends('layouts.main')
@section('content')
@include('shared.usermenu', array('setActive'=>'iwanttobuy'))
@push('scripts')
<script type="text/javascript">
$(function()
{
	 var query_url = '';
	 var products;

	query_url = '/information/create/ajax-state';

	products = new Bloodhound({
		datumTokenizer: function (datum) {
			alert(datum);
			return Bloodhound.tokenizers.obj.whitespace(datum.id);
		},
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		remote: {
			url: query_url+'?search=true&product_name_th=%QUERY',
			filter: function (products) {
				// Map the remote source JSON array to a JavaScript object array
				return $.map(products, function (product) {
					return {
						id: product.id,
						value: product.product_name_th
					};
				});
			},
			wildcard: "%QUERY"
		}
	});
	
	products.initialize();

	$('.typeahead').typeahead({
		hint: false,
		highlight: true,
		minLength: 1,
		autoSelect: true
		}, {
		limit: 60,
		name: 'product_id',
		displayKey: 'value',
		source: products.ttAdapter(),
		templates: {
			header: '<div style="text-align: center;">ชื่อสินค้า</div><hr style="margin:3px; padding:0;" />'
		}
	});

	 $('#productcategorys_id').on('change', function(e){
		product_category_value = e.target.value;

		query_url = '/information/create/ajax-state?search=true&productcategorys_id='+product_category_value;

		products = new Bloodhound({
			datumTokenizer: function (datum) {
				alert(datum);
				return Bloodhound.tokenizers.obj.whitespace(datum.id);
			},
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			remote: {
				url: query_url+'&product_name_th=%QUERY',
				filter: function (products) {
					// Map the remote source JSON array to a JavaScript object array
					return $.map(products, function (product) {
						return {
							id: product.id,
							value: product.product_name_th
						};
					});
				},
				wildcard: "%QUERY"
			}
		});
		
		products.initialize();

		$('.typeahead').typeahead('destroy');
		$('.typeahead').typeahead({
			hint: false,
			highlight: true,
			minLength: 1,
			autoSelect: true
			}, {
			limit: 60,
			name: 'product_id',
			displayKey: 'value',
			source: products.ttAdapter(),
			templates: {
				header: '<div style="text-align: center;">ชื่อสินค้า</div><hr style="margin:3px; padding:0;" />'
			}
		});
	 });


	$('.typeahead').bind('typeahead:select', function(ev, suggestion) {
		$('#products_id').val(suggestion.id);
	});

});
</script>
@endpush
<br/>
<div class="row">
    {!! Form::open(['method'=>'GET','url'=>$url,'class'=>'','role'=>'search'])  !!}
    <div class="col-md-2">
        <select id="category" name="category" class="form-control">
            <option value="">{{ trans('messages.menu_product_category') }}</option>
            @foreach ($productCategoryitem as $key => $itemcategory)
              @if((isset($_GET["category"])) && ($_GET["category"] == $itemcategory->id))
                <option selected value="{{ $itemcategory->id }}">{{ $itemcategory->{ "productcategory_title_".Lang::locale()} }}</option>
              @else
                <option value="{{ $itemcategory->id }}">{{ $itemcategory->{ "productcategory_title_".Lang::locale()} }}</option>
              @endif
            @endforeach
        </select>
    </div>
    <div class="col-md-8">
        <div class="input-group custom-search-form">
            <input value="{{ isset($_GET['search'])? $_GET['search'] : '' }}" type="text" id="productcategorys_id" name="search" class="form-control typeahead" placeholder="{{ trans('messages.search') }}">
            <span class="input-group-btn">
                <button class="btn btn-default" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </span>
        </div>
    </div>
    {!! Form::close() !!}
    <div class="col-md-2">
      <div class="pull-right">
           <a class="btn btn-success" href="{{ url('user/productbuyedit/0') }}">
             <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
             {{ trans('messages.button_add')}}</a>
      </div>
    </div>
</div>
<br/>

<div class="row">
@if(count($items->toArray()['data'])>0)
<?php
foreach(array_chunk($items->toArray()['data'], 3, true) as $div_item)
{
    foreach ($div_item as $col_md_4_item)
    {
		$product_name = MarketController::get_product_name($col_md_4_item['products_id']);
?>
        <div class="col-md-3" title="{{ $col_md_4_item['created_at'] }}">
            <div class="col-item">
                <div class="info">
                    <div class="row">
                        <div class="price col-md-12">
                            <h4>{{ $product_name }}</h4>
							จำนวน : {{ floatval($col_md_4_item['volumnrange_start']) }} - {{ floatval($col_md_4_item['volumnrange_end']) }} {{ $col_md_4_item['units'] }}<br>
							<span class="glyphicon glyphicon-tag"></span>
							<i>{{ $col_md_4_item['product_title'] }}</i><br>
                            <span class="glyphicon glyphicon-map-marker"></span>
                            {{ $col_md_4_item['city'] }} {{ $col_md_4_item['province'] }}
                            <br/><br/>


                        </div>
                    </div>
                    <div class="separator clear-left">
                        <p class="btn-add">
                            <span class="hidden-sm">THB  {{ floatval($col_md_4_item['pricerange_start']) }} - {{ floatval($col_md_4_item['pricerange_end']) }}</span>
                        </p>
                        <p class="btn-details">
                            <i class="fa fa-list"></i>
                            <a href="{{ url('user/productbuyedit/'.$col_md_4_item['id']) }}" class="hidden-sm">{{ trans('messages.button_moredetail')}}</a></p>
                    </div>
                    <div class="clearfix">
                    </div>
                </div>
            </div>
        </div>
<?php
    }
}
?>
@else
<div style="text-align:center; padding:20px;">
  <h1>
    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
    {{ trans('messages.noresultsearch') }}
  </h1>
</div>
@endif
</div>
{!! $items->render() !!}
@stop
