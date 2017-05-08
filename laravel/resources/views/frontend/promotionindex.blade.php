<?php
use App\ProductCategory;
$url = "user/promotion/index";
$pagetitle = trans('message.menu_promotion');
?>
@extends('layouts.main')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="glyphicon glyphicon-apple"></i>')
@section('content')
    @include('shared.usermenu', array('setActive'=>'promotion'))
    <div class="col-sm-12">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h3>{{ trans('messages.addeditform') }}</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="col-lg-12 margin-tb">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                        @if($setting_shop)
                        <div class="alert alert-danger">
                            <strong>{{ trans('messages.required_shop_setting')}}</strong> <a href="{{ url('/user/shopsetting') }}">{{ trans('messages.shop_setting') }}</a>
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
                        <th>{{ trans('validation.attributes.promotion_title') }}</th>
                        <th>{{ trans('validation.attributes.promotion_description') }}</th>
                        <th width="160px">{{ trans('validation.attributes.promotion_start_date') }}</th>
                        <th width="160px">{{ trans('validation.attributes.promotion_end_date') }}</th>
                        <th width="150px" style="text-align:center;">
                            @if(!$setting_shop)
                                <a class="btn btn-success" href="{{ url ('user/promotion/create') }}">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                </a>
                            @endif
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($items) > 0)
                        @foreach ($items as $key => $item)
                            <tr>
                                <td style="text-align:center;">{{ ++$i }}</td>
                                <td>{{ $item->promotion_title }}</td>
                                <td>{{ $item->promotion_description }}</td>
                                <td>{{ DateFuncs::thai_date($item->start_date) }}</td>
                                <td>{{ DateFuncs::thai_date($item->end_date) }}</td>
                                <td style="text-align:center;">
                                    <a target="_bank" class="btn btn-info"
                                       href="{{ url ($shop->shop_name."/promotion/".$item->id) }}">
                                        <span class="glyphicon glyphicon-globe" aria-hidden="true"></span>
                                    </a>
                                    <a class="btn btn-primary"
                                       href="{{ url ('user/promotion/'.$item->id.'/edit') }}">
                                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                    </a>
                                    <?php
                                    $confirmdelete = trans('messages.confirm_delete', ['attribute' => $item->promotion_title]);
                                    ?>
                                    {!! Form::open(['method' => 'DELETE','route' => ['promotion.destroy', $item->id],'style'=>'display:inline']) !!}
                                    <button onclick="return confirm('{{$confirmdelete}}');"
                                            class="btn btn-danger" type="submit">
                                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                    </button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                @if(count($items) > 0)
                    {!! $items->appends(Request::all()) !!}
                @endif
            </div>
        </div>
    </div>
@endsection
