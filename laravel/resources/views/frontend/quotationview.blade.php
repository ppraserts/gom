@extends('layouts.main')
@section('page_heading',trans('message.menu_order_list'))
@section('page_heading_image','<i class="glyphicon glyphicon-apple"></i>')
@section('content')
    @include('shared.usermenu', array('setActive'=>'quotation'))
    <div class="col-sm-12">

        <div class="row">

            <div class="panel panel-default" style="margin-top: 30px">
                <div class="panel-heading">
                    <h4>{{ trans('messages.quotation')}}</h4>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-8">

                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th width="180">{{ trans('messages.quotation_date') }}</th>
                                    <th>{{ trans('messages.i_sale') }}</th>
                                    @if($quotation->user->users_mobilephone !='')
                                        <th>{{ trans('validation.attributes.users_mobilephone') }}</th>
                                    @endif
                                    @if($quotation->user->users_phone !='')
                                        <th>{{ trans('validation.attributes.users_phone') }}</th>
                                    @endif
                                    @if($quotation->user->email !='')
                                        <th>{{ trans('validation.attributes.email') }}</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{  $quotation->updated_at }}</td>
                                    <td>{{  $quotation->users_firstname_th . " " .$quotation->users_lastname_th }}</td>
                                    @if($quotation->user->users_mobilephone !='')
                                        <td>{{ $quotation->user->users_mobilephone }}</td>
                                    @endif
                                    @if($quotation->user->users_phone !='')
                                        <td>{{ $quotation->user->users_phone }}</td>
                                    @endif
                                    @if($quotation->user->email !='')
                                        <td>{{ $quotation->user->email }}</td>
                                    @endif
                                </tr>
                                </tbody>
                            </table>

                            <br>
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>{{ trans('validation.attributes.users_addressname') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $quotation->user->users_addressname . " " . $quotation->user->users_district . " " . $quotation->user->users_city . " " . $quotation->user->users_province . " " . $quotation->user->users_postcode }}</td>
                                </tr>
                                </tbody>
                            </table>

                            <br>
                            <strong>สินค้า</strong>
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>{{ trans('validation.attributes.product_name_th') }}</th>
                                    <th>{{ trans('validation.attributes.product_title') }}</th>
                                    <th>{{ trans('validation.attributes.price') }}</th>
                                    {{--<th>{{ trans('validation.attributes.discount') }}</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{  $quotation->product_name_th }}</td>
                                    <td>{{  $quotation->product_title }}</td>
                                    <td><strong>{{  $quotation->price. " " .$quotation->units }}</strong></td>
                                    {{--<td>{{  $quotation->discount }}</td>--}}
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4">


                            <strong>รูปภาพสินค้า</strong>
                            <br>
                            <br>
                            <img style="width: 100%; overflow: hidden; min-height: 200px;"
                                 src="{{url($quotation->product1_file)}}">
                        </div>
                    </div>
                    @if($user->user_id != $quotation->buyer_id)
                        <div class="row">
                            <div class="col-md-2 col-md-offset-5">

                                <button type="button" class="btn btn-primary"
                                        onclick="addToCart('{{$quotation->product_request_id}}','{{$quotation->user_id}}','{{$quotation->price}}','{{$quotation->min_order}}')">
                                    <i class="fa fa-shopping-cart"></i>
                                    สั่งซื้อสินค้า
                                </button>
                            </div>
                        </div>
                    @endif

                </div>
            </div>


        </div>


    </div>
@endsection
@push('scripts')
<script>

    $(document).ready(function () {

    });

    function addToCart(productRequestId, userId, unit_price, min_order) {
        console.log('hello adToCart');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var targetUrl = '{{url('/user/shoppingcart/addToCart')}}';
        //   alert(targetUrl);
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
            window.location.href = "{{url('user/shoppingcart')}}";
        }
    }

</script>
@endpush