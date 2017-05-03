@extends('layouts.'.$theme) {{--default theme--}}
@section('promotion')

@stop
@section('product')
    @if($products != null)
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3 col-sm-6">
                    <a href="/user/productview/{{$product->id}}">
                        <div class="products-item">
                            <div class="thumbnail">
                                <div class="product-image">
                                    <img class="img-product img-responsive" src="{{asset($product->product1_file)}}"
                                         alt="">
                                </div>
                                <div class="product-detail">
                                    <div class="product-title">
                                        <a href="/user/productview/{{$product->id}}"><h4>{{$product->product_title}}</h4></a>
                                    </div>
                                    <div class="product-price">
                                        {{$product->price}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
@stop

