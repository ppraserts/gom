@extends('layouts.'.$theme) {{--default theme--}}
@section('content')

@stop
@section('product')

    @if($products != null)
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3 col-sm-6">
                    <div class="products-item">
                        <div class="thumbnail">
                            <div class="product-image">
                                <img class="img-product img-responsive" src="{{$shop['shop_name']."/".$product->product1_file}}" alt="">
                            </div>
                            <div class="product-detail">
                                <div class="product-title">
                                    <a href="#"><h4>{{$product->product_title}}</h4></a>
                                </div>
                                <div class="product-price">
                                    {{$product->price}}
                                </div>
                                <a href="#" class="btn btn-primary">Add to cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@stop

