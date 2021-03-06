<?php
//$url = "user/userproduct/index";
$pagetitle = Lang::get('message.menu_add_product');
?>
@extends('layouts.main')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="glyphicon glyphicon-apple"></i>')
@section('content')
    @include('shared.usermenu', array('setActive'=>'addproduct'))
    <div class="col-sm-12">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h3>{{ trans('messages.productall') }}</h3>
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
            <div class="form-group">
                {{--<a href="{{ url('user/userproduct') }}" type="button"
                   class="btn btn-primary">{{ trans('messages.only_me') }}</a>--}}
                <a href="{{ url('user/userproduct/all') }}"
                   class="btn btn-primary">{{ trans('messages.all_product') }}</a>
                {{--<label class="radio-inline">
                    <input type="radio" name="user">{{ trans('messages.only_me') }}
                </label>
                <label class="radio-inline">
                    <input type="radio" name="all">{{ trans('messages.all_product') }}
                </label>--}}
            </div>
        </div>
        <div class="row">
            {!! Form::open(['method'=>'GET','url'=>'user/userproduct-filters','class'=>'','role'=>'search'])  !!}
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
                        <th>{{ Lang::get('validation.attributes.product_name_th') }}</th>
                        <th>{{ Lang::get('validation.attributes.product_name_en') }}</th>
                        <th>{{ Lang::get('messages.menu_product_category') }}</th>
                        <th width="140px"
                            style="text-align:center;">{{ Lang::get('validation.attributes.sequence') }}</th>
                        <th width="130px" style="text-align:center;">
                            <a class="btn btn-success" href="{{ url ('user/userproduct/create') }}" data-toggle="tooltip" title="{{trans('messages.add')}}">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($items as $key => $item)
                        <tr>
                            <td style="text-align:center;">{{ ++$i }}</td>
                            <td>{{ $item->product_name_th }}</td>
                            <td>{{ $item->product_name_en }}</td>
                            <td>{{ $item->productCategory->productcategory_title_th }}</td>
                            <td style="text-align:center;">{{ $item->sequence }}</td>
                            <td style="text-align:center;">

                                <a class="btn btn-primary"
                                   href="{{ url ('user/userproduct/'.$item->id.'/edit') }}"
                                   data-toggle="tooltip"
                                   title="{{trans('messages.edit')}}">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                </a>
                                <?php
                                $confirmdelete = trans('messages.confirm_delete', ['attribute' => $item->product_question_th]);
                                ?>
                                @if($item->user_id == $user_id && count($item->productRequest) == 0)
                                    {!! Form::open(['method' => 'DELETE','route' => ['userproduct.destroy', $item->id],'style'=>'display:inline']) !!}
                                    <button onclick="return confirm('{{$confirmdelete}}');"
                                            class="btn btn-danger" type="submit"
                                            data-toggle="tooltip" title="{{trans('messages.button_delete')}}">
                                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                    </button>
                                @endif

                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $items->appends(Request::all()) !!}
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush