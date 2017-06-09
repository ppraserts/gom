<?php
use App\Http\Controllers\frontend\MarketController;
//$url_filter =  '/user/matchings?filterprice='.$filterprice.'filterquantity='.$filterquantity.'filterprovince='.$filterprovince."&";
$filters = array('filterprice' => $filterprice, 'filterquantity' => $filterquantity, 'filterprovince' => $filterprovince);
?>
@extends('layouts.main')
@section('content')
    @include('shared.usermenu', array('setActive'=>'matchings'))

    <br/>

    <div class="btn-group"><a
                href="{{ route('matchings.index', array_merge($filters,[ 'orderby'=>$orderby,'filterprice'=>!$filterprice])) }}"
                class="btn btn-info"><span class="fa fa-check {{$filterprice ? '' : 'invisible'}}"/></a>
        <a class="btn btn-default {{$filterprice ? '' : 'disabled'}} {{ $orderby == "price" ? 'active' : '' }}"
           href="{{ route('matchings.index', array_merge($filters,[ 'orderby'=>'price','toggleorder'=>$price_order])) }}"
           role="button">
            <span class="fa fa-sort-amount-{{$price_order}}"></span> {{ trans('messages.orderbyprice') }}
        </a>
    </div>
    <div class="btn-group"><a
                href="{{ route('matchings.index', array_merge($filters,[ 'orderby'=>$orderby,'filterquantity'=>!$filterquantity])) }}"
                class="btn btn-info"><span class="fa fa-check {{$filterquantity ? '' : 'invisible'}}"/></a>
        <a class="btn btn-default {{$filterquantity ? '' : 'disabled'}} {{ $orderby == "quantity" ? 'active' : '' }}"
           href="{{ route('matchings.index', array_merge($filters,[ 'orderby'=>'quantity','toggleorder'=>$quantity_order])) }}"
           role="button">
            <span class="fa fa-sort-amount-{{$quantity_order}}"></span> {{ trans('messages.orderbyunit') }}
        </a>
    </div>
    <div class="btn-group"><a
                href="{{ route('matchings.index', array_merge($filters,[ 'orderby'=>$orderby,'filterprovince'=>!$filterprovince])) }}"
                class="btn btn-info"><span class="fa fa-check {{$filterprovince ? '' : 'invisible'}}"/></a>
        <a class="btn btn-default {{$filterprovince ? '' : 'disabled'}} {{ $orderby == "province" ? 'active' : '' }}"
           href="{{ route('matchings.index', array_merge($filters,[ 'orderby'=>'province','toggleorder'=>$province_order])) }}"
           role="button">
            <span class="fa fa-sort-alpha-{{$province_order}}"></span> {{ trans('messages.orderbyprovince') }}
        </a>
    </div>

    <h3>{{ trans('messages.menu_matching_buy') }}</h3>
    @if(count((array)$itemsbuy)>0)
        <div class="row">
            <?php
            $arr = (array)$itemsbuy;
            foreach(array_chunk($arr, 3, true) as $div_item)
            {
            foreach ($div_item as $col_md_4_items)
            {
            $col_md_4_item = (array)$col_md_4_items;
            //            echo json_encode($col_md_4_item);
            //            $product_name = ($col_md_4_item['product_name_th']);

            $imageName_temp = iconv('UTF-8', 'tis620', $col_md_4_item['product1_file']);
            if (!file_exists($imageName_temp)) {
                $col_md_4_item['product1_file'] = '/images/default.jpg';
            }
            ?>
            @if($userItem->iwanttobuy == "buy")
                <div class="col-md-3" title="{{ $col_md_4_item['created_at'] }}">
                    <div class="col-item">
                        <div class="photo">
                            <img style="height:150px; width:350px;" src="{{ url($col_md_4_item['product1_file']) }}"
                                 class="img-responsive" alt="a">
                        </div>
                        <div class="info">
                            <div class="row">
                                <div class="price col-md-12">
                                    <h4 title="{{ $col_md_4_item['product_name_th'] }}"><?php echo mb_strimwidth($col_md_4_item['product_name_th'], 0, 15, '...', 'UTF-8'); ?></h4>
                                    <span class="glyphicon glyphicon-tag"></span>
                                    <i title="{{ $col_md_4_item['product_name_th'] }}"><?php echo mb_strimwidth($col_md_4_item['product_title'], 0, 15, '...', 'UTF-8'); ?></i><br/>
                                    <span class="glyphicon glyphicon-map-marker"></span>
                                    {{ $col_md_4_item['city'] }} {{ $col_md_4_item['province'] }}

                                </div>


                                @if(($col_md_4_item['selling_type'] == "all" || $col_md_4_item['selling_type'] == "wholesale"))
                                    @if($col_md_4_item['quotation_id'] == null)
                                        <div class="col-md-12" style="margin-top: 10px;">
                                            <p class="btn-wholesale">
                                                <i class="fa fa-file-text-o"></i>
                                                <a href="{{ url('user/quotationRequest/'.$col_md_4_item['id']) }}"
                                                   class="hidden-sm">{{ trans('messages.quotation_request')}}</a></p>
                                        </div>
                                    @elseif($col_md_4_item['is_reply'] == 1)
                                        <div class="col-md-12" style="margin-top: 10px;">
                                            <p class="btn-wholesale">
                                                <i class="fa fa-file-text-o"></i>
                                                <a href="{{ url('user/quotation/'.$col_md_4_item['quotation_id']) }}"
                                                   class="hidden-sm">{{ trans('messages.quotation_view')}}</a></p>
                                        </div>
                                    @else
                                        <div class="col-md-12" style="margin-top: 10px;">
                                            <p class="btn-wholesale">
                                                <i class="fa fa-file-text-o"></i>
                                                <span
                                                   class="hidden-sm">{{ trans('messages.quotation_request_waiting')}}</span></p>
                                        </div>
                                    @endif
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <p>
                                        <span class="hidden-sm">  {{ trans('messages.unit_price'). " ".floatval($col_md_4_item['price']). trans('messages.baht')." / ". $col_md_4_item['units'] }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p>
                                        <i class="fa fa-list"></i>
                                        <a href="{{ url('user/productview/'.$col_md_4_item['id']) }}"
                                           class="hidden-sm">{{ trans('messages.button_moredetail')}}</a></p>
                                </div>
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
    @else
        <div style="text-align:center; padding:20px;">
            <h1>
                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                {{ trans('messages.noresultsearch') }}
            </h1>
        </div>
    @endif

    <br/>
    <h3>{{ trans('messages.menu_matching_sale') }}</h3>
    @if(isset($itemssale) && count((array)$itemssale)>0)
        <div class="row">
            <?php
            $arr = (array)$itemssale;
            foreach(array_chunk($arr, 3, true) as $div_item)
            {
            foreach ($div_item as $col_md_4_items)
            {
            $col_md_4_item = (array)$col_md_4_items;
            //            $product_name = MarketController::get_product_name($col_md_4_item['products_id']);

            $imageName_temp = iconv('UTF-8', 'tis620', $col_md_4_item['product1_file']);
            if (!file_exists($imageName_temp)) {
                $col_md_4_item['product1_file'] = '/images/default.jpg';
            }
            ?>
            @if($userItem->iwanttosale == "sale")
                <div class="col-md-3" title="{{ $col_md_4_item['created_at'] }}">
                    <div class="col-item">
                        <div class="info">
                            <div class="row">
                                <div class="price col-md-9">
                                    <h4>{{ $col_md_4_item['product_name_th'] }}</h4>
                                    จำนวน : {{ floatval($col_md_4_item['volumnrange_start']) }}
                                    - {{ floatval($col_md_4_item['volumnrange_end']) }} {{ $col_md_4_item['units'] }}
                                    <br>
                                    <span class="glyphicon glyphicon-tag"></span>
                                    <i>{{ $col_md_4_item['product_title'] }}</i><br>
                                    <span class="glyphicon glyphicon-map-marker"></span>
                                    {{ $col_md_4_item['city'] }} {{ $col_md_4_item['province'] }}
                                    <br/><br/>
                                </div>

                            </div>
                            <div class="separator clear-left">
                                <p class="btn-add">
                                    <span class="hidden-sm">THB {{ floatval($col_md_4_item['pricerange_start']) }}
                                        - {{ floatval($col_md_4_item['pricerange_end']) }}</span>
                                </p>
                                <p class="btn-details">
                                    <i class="fa fa-list"></i>
                                    <a href="{{ url('user/productview/'.$col_md_4_item['id']) }}"
                                       class="hidden-sm">{{ trans('messages.button_moredetail')}}</a></p>
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
    @else
        <div style="text-align:center; padding:20px;">
            <h1>
                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                {{ trans('messages.noresultsearch') }}
            </h1>
        </div>
    @endif
@stop
