@extends('layouts.main')
@section('content')

    {{ Form::open(array('route' => 'shoppingcart.checkoutAll')) }}

    @if ($message = Session::get('success'))
        <div class="row">
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        </div>
    @endif

    @if(isset($shopping_carts))
        @if(count($shopping_carts) > 0)
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            <a href="{{url('result')}}" type="button" class="btn btn-primary">
                                <span class="fa fa-cart-plus"></span> {{ trans('messages.continue_shopping') }}
                            </a>
                            <button type="submit" class="btn btn-info">
                                <span class="fa fa-cart-plus" aria-hidden="true"></span> {{ trans('messages.process_all_order') }}
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <h2 class="text-center">{{ trans('messages.not_found_an_orders') }}</h2>
                <BR>
                <div class="text-center">
                    <a href="{{url('result')}}" type="button" class="btn btn-primary">
                        <span class="fa fa-cart-plus"></span> {{ trans('messages.continue_shopping') }}
                    </a>
                </div>
            </div>
        @endif

        <BR>
        {{--{{dump($shopping_carts)}}--}}

        @php
            $total_net = 0;
        @endphp

        @foreach($shopping_carts as $key => $carts)
            <div style="background-color: white">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-10 col-md-offset-1">
                            @php
                                $user = DB::table('users')->where('id' , $key)->first();
                            @endphp
                            <h3>ร้าน {{$user->users_firstname_th.' '.$user->users_lastname_th}}</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-10 col-md-offset-1">
                            <table id="table_cart" class="table table-hover">
                                <thead>
                                <tr>
                                    <th>{{ trans('messages.shop_product') }}</th>
                                    <th class="text-center">{{ trans('messages.quantity') }}</th>
                                    <th class="text-center">{{ trans('messages.unit_price') }}</th>
                                    <th class="text-center">{{ trans('messages.total') }}</th>
                                    <th> </th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $total = 0;
                                $int_count = 0;
                                @endphp

                                @foreach($carts as $row=> $cart)
                                    @php
                                        $int_count ++;
                                        $total += intval($cart["qty"])*floatval($cart['product_request']['price']);
                                        if(count($carts) == $int_count){
                                            $total_net += $total;
                                        }
                                    @endphp

                                    <tr class="data">
                                        <td class="col-sm-7 col-md-6">
                                            <div class="media">
                                                <a class=" pull-left" href="#" style="margin-right: 10px">
                                                    <img class="media-object" src="{{url($cart['product_request']['product1_file'])}}"
                                                         style="width: 60px; height: 60px;">
                                                </a>
                                                <div class="media-body">
                                                    <h4 class="media-heading"><a href="#">{{$cart['product_request']['product_title']}}</a></h4>
                                                    <h5 class="media-heading"><a href="#"></a></h5>
                                                    <span class="text-success">
                                                        <strong><span class="glyphicon glyphicon-map-marker"></span>
                                                            {{ $cart['product_request']['city'] }} {{ $cart['product_request']['province'] }}</strong>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-sm-2 col-md-2">
                                            <div class="input-append text-left">
                                                <a href="{{ route('shoppingcart.incrementQuantityCartItem' , array('user_id'=> $key , 'product_request_id'=> $cart['product_request']['id'] , 'unit_price'=> $cart['product_request']['price'], 'is_added'=> 0 )) }}"
                                                   class="btn btn-default minus"> <i class="fa fa-minus"></i></a>
                                                <input class="text-center product_quantity" style="max-width: 40px; height: 33px" value="{{$cart["qty"]}}"
                                                       id="appendedInputButtons" size="16" type="text">
                                                <a href="{{ route('shoppingcart.incrementQuantityCartItem' , array('user_id'=> $key , 'product_request_id'=> $cart['product_request']['id'] , 'unit_price'=> $cart['product_request']['price'] , 'is_added'=> 1)) }}"
                                                   class="btn btn-default plus"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </td>
                                        <td class="col-sm-1 col-md-1 text-center"><strong>
                                                <span class="product_price">{{$cart['product_request']['price']}}</span>
                                            </strong></td>
                                        <td class="col-sm-1 col-md-1 text-center">
                                            <strong><span
                                                        class="total">{{ number_format (intval($cart["qty"])*floatval($cart['product_request']['price']), 2 ) }}</span></strong>
                                        </td>
                                        <td class="col-sm-1 col-md-1">
                                            <div class="text-center">
                                                <a href="{{ route('shoppingcart.deleteCartItem' , array('user_id'=> $key , 'product_request_id'=> $cart['product_request']['id'] )) }}"
                                                   type="button" class="btn btn-danger delete-button ">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td style="display:none;"><input type="hidden" value="{{$cart['product_request']['id']}}"></td>
                                        <td style="display:none;"><input type="hidden" value="{{$cart['product_request']['products_id']}}"></td>
                                    </tr>

                                @endforeach
                                <tr>
                                    <td>&nbsp;</td>
                                    <td colspan="2"><h4 class="pull-right">{{ trans('messages.total_order') }}</h4></td>
                                    <td colspan="2" class="text-right"><span
                                                id="order_total"><h4><strong>{{number_format($total)}}</strong> {{ trans('messages.baht') }}</h4> </span></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <a href="{{route('shoppingcart.checkout' , array('user_id'=> $key , 'total'=> $total )  )}}"
                                           class="btn btn-primary"><i class="glyphicon glyphicon-shopping-cart"></i>
                                            {{ trans('messages.process_order') }} </span>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <HR>
        @endforeach
    @endif


    @if(count($shopping_carts) > 0)
        <div style="background-color: white">
            <div class="row">
                <div class="col-md-8"><span class="pull-right"><h3>{{ trans('messages.total_net') }}</h3></span></div>
                <div class="col-md-4"><span class="pull-right"
                                            style="margin-right: 20px"><h3>{{number_format($total_net)}} {{ trans('messages.baht') }}</h3></span></div>
            </div>
        </div>
    @endif

    {{ Form::close() }}

@stop

@push('scripts')
<script>
    $(document).ready(function () {
        hideSuccessMessage();
    });

    function hideSuccessMessage() {
        setTimeout(function () {
            $('.alert-success').hide();
        }, 2000);
    }

</script>
@endpush