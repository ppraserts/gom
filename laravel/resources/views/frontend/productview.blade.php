<?php
function renderHTML($text)
{
    if ($text != "")
        echo "<br/>" . $text;
}

?>
@extends('layouts.main')
@section('content')
    @if($user!=null)
        @include('shared.usermenu', array('setActive'=>''))
    @endif
    <br/>
    <div class="row">
        <div class="col-lg-12">
            <div class="col-md-4" style="padding-right:30px;">
                <a href="#" class="btn btn-default" onclick="history.back();">
                    {{trans('messages.backtoresult')}}
                </a>
                @if($user!=null && $user->id != $productRequest->users_id)
                    @if($productRequest->users_imageprofile != "")
                        <img height="150" width="150" src="{{ url($productRequest->users_imageprofile) }}"
                             class="img-circle">
                        <br/><br/>
                    @endif
                @endif
                <div class="clearfix"
                     style="border-top: 1px solid #d4d4d4; padding-bottom: 10px; margin-top: 5px;"></div>
                @if($productRequest->iwantto == "sale")
                    @include('frontend.product_element.seller')
                @else
                    @include('frontend.product_element.buyer')
                @endif
            </div>

            @if($productRequest->iwantto == "sale")
                @include('frontend.product_element.product_detail')
            @else
                @include('frontend.product_element.want_buy_detail')
            @endif
        </div>
    </div>

    @if($productRequest->iwantto == "sale")
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
                @if($user!=null)
                    @include('frontend.product_element.comment')
                @endif
            </div>
        </div>
    @endif
    <!-- modal product added to cart -->
    @include('frontend.product_element.modal_add_to_cart')
    <!-- /.modal -->
    @if($user==null || ($user!=null && $user->iwanttobuy == 'buy'))
        @if($productRequest->iwantto == "sale")
            @if(($productRequest['selling_type'] == "all" || $productRequest['selling_type'] == "wholesale") && $productRequest['productstatus'] == "open")
                @include('frontend.product_element.modal_add_quotation')
            @endif
        @endif
    @endif
@stop
@push('scripts')
    <link href="{{url('jquery-loading/waitMe.css')}}" rel="stylesheet">
    <script src="{{url('jquery-loading/waitMe.js')}}"></script>
    <script> var partUrl = "{{url('/')}}"; </script>
    <script src="{{url('js/comment_product.js')}}"></script>
    <link rel="stylesheet" href="{{url('css/star.css')}}">
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
                        window.location = BASE_URL + '/user/login';
                    }
                },
                error: function (request, status, error) {
                    window.location = BASE_URL + '/user/login';
                    console.log(request.responseText);
                    //alert(request.responseText);
                }
            });
        }

        function showAddQuotation() {
            $('#modal_add_quotaiton').modal('show');
        }

        function addQuotation(productRequestId) {
            var quantity = $('input[name=quantity]').val();
            if (quantity < 1) {
                $('#quantity-error').css('color', '#a94442');
                $('#quantity-error').html('กรุณากรอกจำนวน');
                return;
            }
            window.location = BASE_URL + '/user/quotationRequest/' + productRequestId + '/' + quantity;
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