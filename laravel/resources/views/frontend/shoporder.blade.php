<?php
$pagetitle = trans('message.menu_order_list');
?>
@extends('layouts.main')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="glyphicon glyphicon-apple"></i>')
@section('content')
    @include('shared.usermenu', array('setActive'=>'shoporder'))
    <div class="col-sm-12">

        <div class="row">
            <h2>{{ trans('messages.menu_shop_order_list') }}</h2>
            <form action="{{url('user/shoporder')}}" method="GET">
                <div class="input-group custom-search-form">
                    <input type="text" id="search" name="filter" class="form-control" value="{{Request::input('filter')}}"
                           placeholder="{{ trans('messages.order_id').'/'.trans('messages.i_buy').'/'.trans('messages.order_status') }}">
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
                        <th style="text-align:center;">{{ trans('messages.order_type') }}</th>
                        <th>{{ trans('messages.i_buy') }}</th>
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
                            <td style="text-align:center;">
                                {{ $item->order_type== 'retail'? trans('messages.retail'): trans('messages.wholesale')}}
                            </td>
                            <td>{{ $item->users_firstname_th. " ". $item->users_lastname_th }}</td>
                            <td style="text-align:center;">{{ \App\Helpers\DateFuncs::mysqlToThaiDate($item->order_date) }}</td>
                            <td style="text-align:center;">{{ $item->total_amount . trans('messages.baht') }}</td>
                            <td style="text-align:center;">{{ $item->status_name }}</td>
                            <td style="text-align:center;">
                                <a class="btn btn-info"
                                   href="{{ url ('user/orderdetail/'.$item->id.'?status=sale') }}">
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
