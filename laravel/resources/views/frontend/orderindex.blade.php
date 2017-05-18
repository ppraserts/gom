<?php
$pagetitle = trans('message.menu_order_list');
?>
@extends('layouts.main')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="glyphicon glyphicon-apple"></i>')
@section('content')
    @include('shared.usermenu', array('setActive'=>'order'))
    <div class="col-sm-12">
        @if ($message = Session::get('success'))
            <div class="row">
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            </div>
        @endif
        <div class="row">
            <h2>{{ trans('messages.menu_order_list') }}</h2>
            <form action="{{url('user/order')}}" method="GET">
                <div class="input-group custom-search-form">
                    <input type="text" id="search" name="filter" class="form-control" value="{{Request::input('filter')}}"
                           placeholder="{{ trans('messages.order_id').'/'.trans('messages.i_sale').'/'.trans('messages.order_status') }}">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="submit">
                          <i class="fa fa-search"></i>
                      </button>
                  </span>
                </div>
            </form>
        </div>
        <div class="row" style="margin-top: 10px">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th width="120px" style="text-align:center;">{{ trans('messages.order_id') }}</th>
                        <th>{{ trans('messages.i_sale') }}</th>
                        <th style="text-align:center;">{{ trans('messages.order_date') }}</th>
                        <th style="text-align:center;">{{ trans('messages.order_total') }}</th>
                        <th style="text-align:center;">{{ trans('messages.order_status') }}</th>
                        <th width="130px" style="text-align:center;">
                            {{ trans('messages.view_order_detail') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($orderList as $key => $item)
                        <tr>
                            <td style="text-align:center;">{{ $item->id }}</td>
                            <td>{{ $item->users_firstname_th. " ". $item->users_lastname_th }}</td>
                            <td style="text-align:center;">{{ $item->order_date }}</td>
                            <td style="text-align:center;">{{ $item->total_amount . trans('messages.baht') }}</td>
                            <td style="text-align:center;">{{ $item->status_name }}</td>
                            <td style="text-align:center;">
                                <a class="btn btn-info"
                                   href="{{ url ('user/orderdetail/'.$item->id) }}">
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
