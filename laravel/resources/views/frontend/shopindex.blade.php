@extends('layouts.'.$theme) {{--default theme--}}
@section('promotion')

@stop
@section('product')
    @if($products != null)
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3 col-sm-6">
                    <div class="products-item">
                        <div class="thumbnail">
                            <div class="product-image">
                                <img class="img-product img-responsive" src="{{asset($product->product1_file)}}" alt="">
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


            <div class="col-md-6">
                <div class="promotion-item">
                    <a href="#">xxxx
                        <img class="img-promotion img-responsive" src="{{$promotions[0]->image_file}}">
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="promotion-item">
                    <a href="#">xxxx
                        <img class="img-promotion img-responsive"
                             src="http://gom.localhost/assets/theme/images/theme-one_01.jpg">
                    </a>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="promotion-item">
                            <a href="#">
                                <img class="img-promotion img-responsive" src="assets/theme/images/theme-one_03.jpg">
                            </a>
                        </div>
                        <div class="promotion-item">
                            <a href="#">
                                <img class="img-promotion img-responsive" src="assets/theme/images/theme-one_05.jpg">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="promotion-item">
                            <a href="#">
                                <img class="img-promotion img-responsive" src="assets/theme/images/theme-one_04.jpg">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="promotion-item">
                    <a href="#">
                        <img class="img-promotion img-responsive" src="assets/theme/images/theme-one_06.jpg">
                    </a>
                </div>
            </div>
        </div>
    @endif
@stop

