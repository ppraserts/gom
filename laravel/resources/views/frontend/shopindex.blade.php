@extends('layouts.'.$theme) {{--default theme--}}
@section('promotion')
    @if(count($promotions) > 0 )
        <section class="promotions">

                <div class="row">
                    <div class="col-lg-12 text-center">
                        @foreach($promotions as $promotion)
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="promotion-item">
                                        <a href="{{url($shop->shop_name."/promotion/".$promotion->id)}}"
                                           title="{{$promotion->promotion_title}}">
                                            @if(isset($promotion->image_file))
                                                <img class="img-promotion img-responsive"
                                                     src="{{url( $promotion->image_file)}}">

                                            @else
                                                <div class="promotion-text-box">
                                                    <h3 class="promotion-text">{{ mb_strimwidth(strip_tags($promotion->promotion_title), 0, 48, "UTF-8")}}</h3>
                                                </div>
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
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
                                        <a href="{{url('/user/productview/' . $product->id)}}">
                                            <h4>{{$product->product_title}}</h4>
                                        </a>
                                    </div>
                                    @if($theme == 'theme2')
                                        <div class="product-price-t2">
                                            @else
                                                <div class="product-price">
                                                    @endif

                                                    {{$product->price}}
                                                </div>
                                        </div>
                                </div>
                            </div>
                    </a>
                </div>
            @endforeach
            @if(count($products) > 0)
                <div class="col-md-12 col-sm-12">
                    <a href="{{url('result?category=&search='.$shop->shop_name)}}" class="btn btn-default">
                        {{trans('messages.view_product_all')}}
                    </a>
                </div>
            @endif
        </div>
    @endif
@stop