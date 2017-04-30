<?php
$pagetitle = Lang::get('message.menu_order_list');
?>
@extends('layouts.main')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="glyphicon glyphicon-apple"></i>')
@section('content')
    @include('shared.usermenu', array('setActive'=>'order'))
    <div class="col-sm-12">

        <div class="row">
            <h2>{{ trans('messages.menu_order_list') }}</h2>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="col-lg-12 margin-tb">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>{{ trans('messages.message_whoops_error')}}</strong> {{ trans('messages.message_result_error')}}
                            <br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 10px">

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th width="120px" style="text-align:center;">{{ trans('messages.order_id') }}</th>
                        <th>{{ Lang::get('messages.i_sale') }}</th>
                        <th style="text-align:center;">{{ Lang::get('messages.order_date') }}</th>
                        <th style="text-align:center;">{{ Lang::get('messages.order_total') }}</th>
                        <th style="text-align:center;">{{ Lang::get('messages.order_status') }}</th>
                        <th width="130px" style="text-align:center;">
                            {{ Lang::get('messages.view_order_detail') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($orderList as $key => $item)
                        <tr>
                            <td style="text-align:center;">{{ $item->id }}</td>
                            <td>{{ $item->user->users_firstname_th. " ". $item->user->users_lastname_th }}</td>
                            <td style="text-align:center;">{{ $item->order_date }}</td>
                            <td style="text-align:center;">{{ $item->total_amount, trans('messages.baht') }}</td>
                            <td style="text-align:center;">{{ $item->order_status }}</td>
                            <td style="text-align:center;">
                                <a class="btn btn-info"
                                   href="{{ url ('user/order/detail/'.$item->id) }}">
                                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $orderList->appends(Request::all()) !!}
            </div>
        </div>
    </div>
@endsection
