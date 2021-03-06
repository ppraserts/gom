@extends('layouts.'.$theme) {{--default theme--}}
@section('header')
    <div class="text-vertical-center">
        <div class="headline">
            <h2 style="color: {{ $shop->text_color }};">{{$shop->shop_subtitle}}</h2>
            <h1 style="color: {{ $shop->text_color }};">{{$shop->shop_title}}</h1>
            <p style="color: {{ $shop->text_color }};">{{$shop->shop_description}}</p>
        </div>
    </div>
@stop
@section('promotion')
    @if(count($promotions) > 0 )
        <section class="promotions">


            <div class="text-center">
                @foreach($promotions as $promotion)
                    <div class="promotion-item" style="width: 745px; display: inline-block;">
                        <a href="{{url($shop->shop_name."/promotion/".$promotion->id)}}"
                           title="{{$promotion->promotion_title}}">
                            @if(isset($promotion->image_file))
                                <img class="img-promotion img-responsive"
                                     src="{{url( $promotion->image_file)}}">
                                <h4 style="color: #000000;">{{ mb_strimwidth(strip_tags($promotion->promotion_title), 0, 48, "UTF-8")}}</h4>
                            @else
                                <div class="promotion-text-box">
                                    <h3 class="promotion-text">{{ mb_strimwidth(strip_tags($promotion->promotion_title), 0, 48, "UTF-8")}}</h3>
                                </div>
                            @endif
                        </a>
                    </div>
                    <br>
                @endforeach
            </div>

        </section>
    @endif
@stop
@section('product')
    @if($products != null)
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3 col-sm-6">
                    <a href="{{ url('/user/productview/'.$product->id) }}">
                        <div class="products-item">
                            <div class="thumbnail">
                                <div class="product-image">
                                    <img class="img-product img-responsive" src="{{asset($product->product1_file)}}"
                                         alt=""
                                         style="min-height: 150px; height: auto;  position: absolute;left: -100%;right: -100%;top: -100%;bottom: -100%;margin: auto;">
                                </div>
                                <div class="product-detail">
                                    <div class="product-title">
                                        <h4 style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">{{$product->product_name_th}}</h4>
                                        <h4 style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">{{$product->product_title}}</h4>
                                    </div>
                                    <div class="{{ $theme == 'theme2' ? 'product-price-t2' : 'product-price'}}">
                                        {{ trans('messages.unit_price'). " ".floatval($product->price). trans('messages.baht')." / ". $product->units }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
            @if(count($products) > 0)
                <div class="col-md-12 col-sm-12">
                    <a href="{{url('result?category=&search='.$shop->shop_name.$allMarketsStr)}}" class="btn btn-default">
                        {{trans('messages.view_product_all')}}
                    </a>
                </div>
            @endif
        </div>
    @endif
@stop
@push('scripts')
<script> var partUrl = "{{url('/')}}"; </script>
<script src="{{url('js/comment_shop.js')}}"></script>
@endpush