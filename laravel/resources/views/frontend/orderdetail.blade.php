<?php
$pagetitle = trans('message.menu_order_list');
?>
@extends('layouts.main')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="glyphicon glyphicon-apple"></i>')
@section('content')
    @include('shared.usermenu', array('setActive'=>'order'))
    <div class="col-sm-12">

        <div class="row">

            <h2>{{ trans('messages.order_detail') }}</h2>

            <div class="col-md-4">
                <div class="row">
                    <h3>{{ trans('messages.order_id') . " : " . $order->id }}</h3>
                    <p><b>{{ trans('messages.order_date') }} : </b>{{$order->order_date}}</p>
                    <p><b>{{ trans('messages.order_status') }} : </b>{{$order->status_name}}</p>
                    <p><b>{{ trans('messages.order_type') }} : </b>{{$order->order_type}}</p>
                    <h4><b>{{ trans('messages.total_order') }}
                            : </b>{{$order->total_amount}}  {{trans('messages.baht')}}
                    </h4>
                </div>
            </div>

            <div class="col-md-4">
                <div class="row">
                    <h3>{{ trans('messages.i_buy') }}</h3>

                    <p><b>{{ trans('validation.attributes.name') }}
                            : </b>{{$order->buyer->users_firstname_th. " ". $order->buyer->users_lastname_th}}</p>
                    @if(isset($order->buyer->user->users_mobilephone))<p>
                        <b>{{ trans('validation.attributes.users_mobilephone') }}
                            : </b>{{ $order->buyer->user->users_mobilephone }}</p>@endif
                    @if(isset($order->buyer->user->users_phone))<p><b>{{ trans('validation.attributes.users_phone') }}
                            : </b>{{ $order->buyer->user->users_phone }}</p>@endif
                    @if(isset($order->buyer->user->email))<p><b>{{ trans('validation.attributes.email') }}
                            : </b>{{ $order->buyer->user->email }}</p>@endif
                    <p><b>{{ trans('validation.attributes.users_addressname') }}
                            : </b>{{ $order->buyer->users_addressname . " " . $order->buyer->users_district . " " . $order->buyer->users_city . " " . $order->buyer->users_province . " " . $order->buyer->users_postcode }}
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="row">
                    <h3>{{ trans('messages.i_sale') }}</h3>

                    <p><b>{{ trans('validation.attributes.name') }}
                            : </b>{{$order->user->users_firstname_th. " ". $order->user->users_lastname_th}}</p>
                    @if(isset($order->user->users_mobilephone))<p>
                        <b>{{ trans('validation.attributes.users_mobilephone') }}
                            : </b>{{ $order->user->users_mobilephone }}</p>@endif
                    @if(isset($order->user->users_phone))<p><b>{{ trans('validation.attributes.users_phone') }}
                            : </b>{{ $order->user->users_phone }}</p>@endif
                    @if(isset($order->user->email))<p><b>{{ trans('validation.attributes.email') }}
                            : </b>{{ $order->user->email }}</p>@endif
                    <p><b>{{ trans('validation.attributes.users_addressname') }}
                            : </b>{{ $order->user->users_addressname . " " . $order->user->users_district . " " . $order->user->users_city . " " . $order->user->users_province . " " . $order->user->users_postcode }}
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <h3>{{ trans('messages.product_list') }}</h3>
                    <div class="table-responsive">
                        <table style="width: 96%;" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th width="70px" style="text-align:center;">{{ trans('messages.order_id') }}</th>
                                <th>{{ trans('messages.shop_product') }}</th>
                                <th width="100px" style="text-align:center;">{{ trans('messages.quantity') }}</th>
                                <th width="110px" style="text-align:center;">{{ trans('validation.attributes.price') }}</th>
                                <th width="110px" style="text-align:center;">{{ trans('messages.total_order') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0 ?>
                            @foreach ($order->orderItems as $key => $item)
                                <tr>
                                    <td style="text-align:center;">{{ ++$i }}</td>
                                    <td>{{ $item->product_name_th }}</td>
                                    <td style="text-align:center;">{{ $item->quantity ." ". $item->units }}</td>
                                    <td style="text-align:center;">{{ $item->unit_price . trans('messages.baht') }}</td>
                                    <td style="text-align:center;">{{ $item->total . trans('messages.baht') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <h3>{{ trans('messages.order_status') }}</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th style="text-align:center;">{{ trans('validation.attributes.created_at') }}</th>
                                <th style="text-align:center;">{{ trans('messages.order_status') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0 ?>
                            @foreach ($order->statusHistory as $key => $item)
                                <tr>
                                    <td style="text-align:center;">{{ $item->created_at}}</td>
                                    <td style="text-align:center;">{{ $item->status_name }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection