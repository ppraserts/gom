@extends('layouts.'.$theme) {{--default theme--}}
@section('promotion')

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
                                         alt="" style="min-height: 150px; height: auto;  position: absolute;left: -100%;right: -100%;top: -100%;bottom: -100%;margin: auto;">
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