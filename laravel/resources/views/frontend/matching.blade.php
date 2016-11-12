<?php
$url = "user/iwanttosale";
?>
@extends('layouts.main')
@section('content')
@include('shared.usermenu', array('setActive'=>'matchings'))
<br/>
<div class="row">
<?php
$arr = (array)$items;
foreach(array_chunk($arr, 3, true) as $div_item)
{
    foreach ($div_item as $col_md_4_items)
    {
        $col_md_4_item = (array)$col_md_4_items;
?>
        @if($userItem->iwantto == "buy")
        <div class="col-md-4">
            <div class="col-item">
                <div class="photo">
                    <img style="height:260px; width:350px;" src="{{ url($col_md_4_item['product1_file']) }}" class="img-responsive" alt="a">
                </div>
                <div class="info">
                    <div class="row">
                        <div class="price col-md-8">
                            <h4>{{ $col_md_4_item['product_title'] }}</h4>
                            <span class="glyphicon glyphicon-map-marker"></span>
                            {{ $col_md_4_item['city'] }} {{ $col_md_4_item['province'] }}
                            <br/><br/>
                        </div>
                        <div class="rating hidden-sm col-md-4">
                            <span class="glyphicon glyphicon-record" aria-hidden="true" style=" color: {{ $col_md_4_item['Colors']  }};"></span>
                        </div>
                    </div>
                    <div class="separator clear-left">
                        <p class="btn-add">
                            <span class="hidden-sm">  {{ $col_md_4_item['is_showprice']? $col_md_4_item['price'] : '-' }}</span>
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
        @endif
        @if($userItem->iwantto == "sale")
        <div class="col-md-4">
            <div class="col-item">
                <div class="info">
                      <div class="row">
                        <div class="price col-md-8">
                             <h4>{{ $col_md_4_item['product_title'] }} : {{ $col_md_4_item['volumnrange_start'] }} - {{ $col_md_4_item['volumnrange_end'] }} {{ $col_md_4_item['units'] }}</h4>
                            <span class="glyphicon glyphicon-map-marker"></span>
                            {{ $col_md_4_item['city'] }} {{ $col_md_4_item['province'] }}
                            <br/><br/>
                        </div>
                        <div class="rating hidden-sm col-md-4">
                            <span class="glyphicon glyphicon-record" aria-hidden="true" style=" color: {{ $col_md_4_item['Colors']  }};"></span>
                        </div>
                    </div>
                    <div class="separator clear-left">
                        <p class="btn-add">
                            <span class="hidden-sm">THB  {{ $col_md_4_item['pricerange_start'] }} - {{ $col_md_4_item['pricerange_end'] }}</span>
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
        @endif
<?php
    }
}
?>
</div>
@stop
