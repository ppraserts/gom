<?php
$url = "user/quote/index";
$i = 0;
?>
@extends('layouts.main')
@section('page_heading',trans('message.menu_quotation'))
@section('page_heading_image','<i class="glyphicon glyphicon-apple"></i>')
@section('content')
    @include('shared.usermenu', array('setActive'=>'quote'))
    <div class="col-sm-12">
        <h3>{{trans('messages.menu_quotation_request')}}</h3>
        <div class="row">
            <div class="col-sm-12">
                <div class="col-lg-12 margin-tb">

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
        <div class="row">
            {!! Form::open(['method'=>'GET','url'=>$url,'class'=>'','role'=>'search'])  !!}
            <div class="input-group custom-search-form">
                <input type="text" id="search" name="search" class="form-control"
                       placeholder="{{ trans('messages.search') }}
                               ...">
                <span class="input-group-btn">
                      <button class="btn btn-default" type="submit">
                          <i class="fa fa-search"></i>
                      </button>
                  </span>
            </div>
            {!! Form::close() !!}
        </div>
        <div class="row" style="margin-top: 10px">

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th width="60px" style="text-align:center;">{{ trans('messages.no') }}</th>
                        <th width="160px">{{ trans('messages.quotation_request_date') }}</th>
                        <th>{{ trans('validation.attributes.product_name_th') }}</th>
                        <th>{{ trans('validation.attributes.product_title') }}</th>
                        <th width="220px" style="text-align:center;">{{ trans('messages.Description') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($quotations) > 0)
                        @foreach ($quotations as $key => $item)
                            <tr>
                                <td style="text-align:center;">{{ ++$i }}</td>
                                <td>{{ \App\Helpers\DateFuncs::mysqlToThaiDate($item->created_at,true) }}</td>
                                <td>{{ $item->product_name_th }}</td>
                                <td>{{ $item->product_title }}</td>
                                <td style="text-align:center;">
                                    @if($item->is_reply == 1)
                                        <a class="btn btn-info"
                                           href="{{ url ('user/quote/'.$item->id) }}">
                                            {{ trans('messages.quotation_view') }}</span>
                                        </a>
                                    @else
                                        <a class="btn btn-primary"
                                           href="{{ url ('user/quote/'.$item->id.'/edit') }}">
                                            {{ trans('messages.menu_quotation_request') }}
                                        </a>

                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                @if(count($quotations) > 0)
                    {!! $quotations->appends(Request::all()) !!}
                @endif
            </div>
        </div>
    </div>
@endsection
