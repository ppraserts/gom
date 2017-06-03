<?php
function renderHTML($text)
{
    if ($text != "")
        echo "<br/>" . $text;
}

?>
@extends('layouts.main')
@section('content')
    @include('shared.usermenu', array('setActive'=>''))
    <br/>
    <div class="row">
        <div class="col-lg-12">
            <div class="col-md-4" style="padding-right:30px;">
                @if($user->id == $productRequest->users_id)
                    <a href="{{ url('user/productsaleedit/'.$productRequest->id)  }}" class="btn btn-primary">
                        <span class="glyphicon glyphicon-pencil"></span> {{trans('messages.edit')}}
                    </a>
                @else
                    @if($productRequest->users_imageprofile != "")
                        <img height="150" width="150" src="{{ url($productRequest->users_imageprofile) }}" class="img-circle">
                        <br/><br/>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            {{--@if($useritem->id == $item->)--}}
                            @if($productRequest->users_membertype == "personal")
                                {{ $productRequest->users_firstname .Lang::locale() }}
                                {{ $productRequest->users_lastname .Lang::locale() }}
                            @endif
                            @if($productRequest->users_membertype == "company")
                                {{ $productRequest->users_company .Lang::locale() }}
                            @endif
                            {{ renderHTML($productRequest->users_mobilephone) }}
                            {{ renderHTML($productRequest->users_phone) }}
                            {{ renderHTML($productRequest->users_fax) }}
                            {{ renderHTML($productRequest->email) }}
                            <br/><br/>
                            <button type="button" class="btn btn-primary">{{ trans('messages.inbox_message') }}</button>
                            <br/><br/>

                        </div>
                    </div>

                    @if($productRequest['selling_type'] == "all" || $productRequest['selling_type'] == "wholesale")
                        <a href="{{ url('user/quotationRequest/'.$productRequest['id']) }}"
                           class="btn btn-primary">{{trans('messages.quotation_request')}}</a>

                    @endif
                @endif
                <div class="clearfix" style="border-top: 1px solid #d4d4d4; padding-bottom: 10px;"></div>
                @include('frontend.product_element.seller')
                    <div class="row">
                        <div class="col-md-12">
                <div class="clearfix" style="border-top: 1px solid #d4d4d4; padding-bottom: 10px;"></div>
                    <p><strong>{{ $productRequest->product_title }}</strong></p>
                    <p>
                        {{ trans('validation.attributes.price') }} :
                        <strong>
                            @if($productRequest->iwantto == "buy")
                                {{ floatval($productRequest->pricerange_start) }}
                                - {{ floatval($productRequest->pricerange_end) }}
                            @endif
                            @if($productRequest->iwantto == "sale")
                                @if($productRequest->is_showprice)
                                    {{ floatval($productRequest->price) }}
                                @endif
                                @if(!$productRequest->is_showprice)
                                    {{ trans('messages.product_no_price') }}
                                @endif
                            @endif
                        </strong>
                    </p>

                    <p>
                        {{ trans('validation.attributes.volumn') }} :
                        <strong>
                            @if($productRequest->iwantto == "buy")
                                {{ floatval($productRequest->volumnrange_start) }}
                                - {{ floatval($productRequest->volumnrange_end) }}  {{ $productRequest->units }}
                            @endif
                            @if($productRequest->iwantto == "sale")
                                {{ floatval($productRequest->volumn) }} {{ $productRequest->units }}
                            @endif
                        </strong>
                    </p>
                    <p>
                        <span class="glyphicon glyphicon-map-marker"></span>
                        {{ $productRequest->city }} {{ $productRequest->province }}
                    </p>

                    @if($productRequest['productstatus'] == 'open')
                        <p>
                            <button type="button" onclick="addToCart('{{$productRequest['id']}}' , '{{$productRequest['users_id']}}' , '{{$productRequest['price']}}' , '{{$productRequest['min_order']}}')"
                                    class="btn btn-primary">
                                <i class="fa fa-shopping-cart"></i> {{trans('messages.add_to_cart')}}
                            </button>
                        </p>
                    @endif
                        </div>
                    </div>
            </div>
            <div class="col-md-8" style="background-color:#FFFFFF; padding:20px;">
                @if($productRequest->iwantto == "sale")
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            @if($productRequest->product1_file != "")
                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            @endif
                            @if($productRequest->product2_file != "")
                                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            @endif
                            @if($productRequest->product3_file != "")
                                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            @endif
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            @if($productRequest->product1_file != "")
                                <div class="item crop-height-slide active">
                                    <a href="{{ url($productRequest->product1_file) }}" data-lightbox="products"
                                       data-title="{{ trans('validation.attributes.product1_file') }}">
                                        <img class="scale setHeight" src="{{ url($productRequest->product1_file) }}">
                                    </a>
                                    <div class="carousel-caption"></div>
                                </div>
                            @endif
                            @if($productRequest->product2_file != "")
                                <div class="item crop-height-slide">
                                    <a href="{{ url($productRequest->product2_file) }}" data-lightbox="products"
                                       data-title="{{ trans('validation.attributes.product2_file') }}">
                                        <img class="scale setHeight" src="{{ url($productRequest->product2_file) }}">
                                    </a>
                                    <div class="carousel-caption"></div>
                                </div>
                            @endif
                            @if($productRequest->product3_file != "")
                                <div class="item crop-height-slide">
                                    <a href="{{ url($productRequest->product3_file) }}" data-lightbox="products"
                                       data-title="{{ trans('validation.attributes.product3_file') }}">
                                        <img class="scale setHeight" src="{{ url($productRequest->product3_file) }}">
                                    </a>
                                    <div class="carousel-caption"></div>
                                </div>
                            @endif
                        </div>

                        <!-- Controls -->
                        <a class="left carousel-control" href="#carousel-example-generic" role="button"
                           data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" role="button"
                           data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <br/>
                @endif

            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">
        <div class="col-lg-12">
            <div class="detailBox">
                <div class="commentBox row">
                <h4>{{ trans('messages.text_detail_product') }} : {{ $productRequest->product_title }}</h4>
                <p>{!! $productRequest->product_description !!}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">
        <div class="col-lg-12">
            <link rel="stylesheet" href="{{url('font-awesome/css/font-awesome.min.css')}}">
            <link rel="stylesheet" href="{{url('css/star.css')}}">
            <link rel="stylesheet" href="{{url('css/comment.css')}}">
            @include('frontend.product_element.comment')
        </div>
    </div>
    <!-- modal product added to cart -->
    @include('frontend.product_element.modal_add_to_cart')
    <!-- /.modal -->
@stop
@push('scripts')
<link href="{{url('jquery-loading/waitMe.css')}}" rel="stylesheet">
<script src="{{url('jquery-loading/waitMe.js')}}"></script>
<script> var partUrl = "{{url('/')}}"; </script>
<script src="{{url('js/comment_product.js')}}"></script>
<script>

    var BASE_URL = '<?php echo url('/')?>';

    $(document).ready(function () {
        $('#modal_add_to_cart').on('hidden.bs.modal', function () {
            location.reload();
        });
    });

    function addToCart(productRequestId, userId, unit_price, min_order) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var targetUrl = BASE_URL + '/user/shoppingcart/addToCart';
        $.ajax({
            type: 'POST',
            url: targetUrl,
            data: {
                _token: CSRF_TOKEN,
                product_request_id: productRequestId,
                user_id: userId,
                unit_price: unit_price,
                min_order: min_order
            },
            dataType: 'json',
            success: function (response) {
                if (response.status == 'success') {
                    showProductAdded(response.product_request);
                } else {
                    window.location = 'user/login';
                }
            },
            error: function (request, status, error) {
                window.location = 'user/login';
                console.log(request.responseText);
                //alert(request.responseText);
            }
        });
    }


    function showProductAdded(productRequest) {
        if (productRequest != null) {
            $('#img_product').attr('src', BASE_URL + '/' + productRequest.product1_file);
            $('#div_product_description').html(productRequest.product_description);
            $('#div_product_title').html(productRequest.product1_title);
            $('#sp_product_price').text(productRequest.price);
            $('#sp_product_volume').text(productRequest.volumn);
            $('#units').html(productRequest.units);
        }
        $('#modal_add_to_cart').modal('show');
    }

</script>
@endpush