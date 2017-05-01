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

            <div class="col-md-6">
                <div class="row">
                    <h4>{{ trans('messages.order_id') . " : " . $order->id }}</h4>
                    <p><b>{{ trans('messages.order_date') }} : </b>{{$order->order_date}}</p>
                    <p><b>{{ trans('messages.order_status') }} : </b>{{$order->orderStatusName->status_name}}</p>
                    <p><b>{{ trans('messages.order_type') }} : </b>{{$order->order_type}}</p>
                    <h4><b>{{ trans('messages.total_order') }} : </b>{{$order->total_amount}}  {{trans('messages.baht')}}
                    </h4>
                </div>
            </div>

            <div class="col-md-6">
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
            <h3>{{ trans('messages.product_list') }}</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th width="120px" style="text-align:center;">{{ trans('messages.order_id') }}</th>
                        <th>{{ trans('messages.shop_product') }}</th>
                        <th style="text-align:center;">{{ trans('messages.unit_price') }}</th>
                        <th style="text-align:center;">{{ trans('messages.quantity') }}</th>
                        <th style="text-align:center;">{{ trans('messages.total_order') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0 ?>
                    @foreach ($order->orderItems as $key => $item)
                        <tr>
                            <td style="text-align:center;">{{ ++$i }}</td>
                            <td>{{ $item->product_name_th }}</td>
                            <td style="text-align:center;">{{ $item->unit_price . trans('messages.baht') }}</td>
                            <td style="text-align:center;">{{ $item->quantity ." ". $item->units }}</td>
                            <td style="text-align:center;">{{ $item->total . trans('messages.baht') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection