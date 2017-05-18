<?php
use App\Http\Controllers\frontend\MarketController;
?>
@extends('layouts.main')
@section('content')
@include('shared.search')
<br/>
<h3>{{ trans('messages.i_want_to_sale') }}</h3>
@if(count((array)$itemssale)>0)
<div class="row">
<?php
$arr = (array)$itemssale;
foreach(array_chunk($arr, 3, true) as $div_item)
{
    foreach ($div_item as $col_md_4_items)
    {
        $col_md_4_item = (array)$col_md_4_items;

		$product_name = MarketController::get_product_name($col_md_4_item['products_id']);
	
		$imageName_temp = iconv('UTF-8', 'tis620',$col_md_4_item['product1_file']);
		if(!file_exists($imageName_temp))
		{
			$col_md_4_item['product1_file'] = '/images/default.jpg';
		}
?>
          <div class="col-md-3" title="{{ $col_md_4_item['created_at'] }}">
              <div class="col-item">
                  <div class="photo crop-height">
						<img src="{{ url($col_md_4_item['product1_file']) }}" class="scale" alt="a">
                  </div>
                  <div class="info">
                      <div class="row">
                          <div class="price col-md-8">
                              <h4 title="{{ $product_name }}"><?php echo mb_strimwidth($product_name, 0, 15, '...', 'UTF-8'); ?></h4>
							  <span class="glyphicon glyphicon-tag"></span>
							  <i title="{{ $product_name }}"><?php echo mb_strimwidth($col_md_4_item['product_title'], 0, 15, '...', 'UTF-8'); ?></i><br/>
                              <span class="glyphicon glyphicon-map-marker"></span>
                              {{ $col_md_4_item['city'] }} {{ $col_md_4_item['province'] }}
                              <br/><br/>
                          </div>
                          <div class="rating hidden-sm col-md-4">

                          </div>
                      </div>
                      <div class="separator clear-left">
                          <p class="btn-add">
                              <span class="hidden-sm">  {{ $col_md_4_item['is_showprice']? floatval($col_md_4_item['price']) : trans('messages.product_no_price') }}</span>
                          </p>
                          <p class="btn-details">
                              <i class="fa fa-list"></i>
                              <a href="{{ url('user/productview/'.$col_md_4_item['id']) }}" class="hidden-sm">{{ trans('messages.button_moredetail')}}</a></p>
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
</div>
@else
<div style="text-align:center; padding:20px;">
  <h1>
    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
    {{ trans('messages.noresultsearch') }}
  </h1>
</div>
@endif
<br/>
<h3>{{ trans('messages.i_want_to_buy') }}</h3>
@if(count((array)$itemsbuy)>0)
<div class="row">
<?php
$arr = (array)$itemsbuy;
foreach(array_chunk($arr, 3, true) as $div_item)
{
    foreach ($div_item as $col_md_4_items)
    {
        $col_md_4_item = (array)$col_md_4_items;
?>
        <div class="col-md-3" title="{{ $col_md_4_item['created_at'] }}">
            <div class="col-item">
                <div class="info">
                      <div class="row">
                        <div class="price col-md-9">
                             <h4>{{ $col_md_4_item['product_title'] }} : {{ floatval($col_md_4_item['volumnrange_start']) }} - {{ floatval($col_md_4_item['volumnrange_end']) }} {{ $col_md_4_item['units'] }}</h4>
                            <span class="glyphicon glyphicon-map-marker"></span>
                            {{ $col_md_4_item['city'] }} {{ $col_md_4_item['province'] }}
                            <br/><br/>
                        </div>
                        <div class="rating hidden-sm col-md-3">
                        </div>
                    </div>
                    <div class="separator clear-left">
                        <p class="btn-add">
                            <span class="hidden-sm">THB  {{ floatval($col_md_4_item['pricerange_start']) }} - {{ floatval($col_md_4_item['pricerange_end']) }}</span>
                        </p>
                        <p class="btn-details">
                            <i class="fa fa-list"></i>
                            <a href="{{ url('user/productview/'.$col_md_4_item['id']) }}" class="hidden-sm">{{ trans('messages.button_moredetail')}}</a></p>
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
</div>
@else
<div style="text-align:center; padding:20px;">
  <h1>
    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
    {{ trans('messages.noresultsearch') }}
  </h1>
</div>
@endif
@stop
