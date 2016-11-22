<?php
$url = "user/iwanttosale";
?>
@extends('layouts.main')
@section('content')
@include('shared.usermenu', array('setActive'=>'iwanttosale'))
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
            <input value="{{ isset($_GET['search'])? $_GET['search'] : '' }}" type="text" id="search" name="search" class="form-control" placeholder="{{ trans('messages.search') }}">
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
           <a class="btn btn-success" href="{{ url('user/productsaleedit/0') }}">
             <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
             {{ trans('messages.button_add')}}</a>
      </div>
    </div>
</div>
<br/>

<div class="row">
<?php
foreach(array_chunk($items->toArray()['data'], 3, true) as $div_item)
{
    foreach ($div_item as $col_md_4_item)
    {
?>
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
                            {{ $col_md_4_item['productstatus'] }}
                        </div>
                    </div>
                    <div class="separator clear-left">
                        <p class="btn-add">
                            <span class="hidden-sm">  {{ floatval($col_md_4_item['price']) }}</span>
                        </p>
                        <p class="btn-details">
                            <i class="fa fa-list"></i>
                            <a href="{{ url('user/productsaleedit/'.$col_md_4_item['id']) }}" class="hidden-sm">{{ trans('messages.button_moredetail')}}</a></p>
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
{!! $items->render() !!}
@stop
