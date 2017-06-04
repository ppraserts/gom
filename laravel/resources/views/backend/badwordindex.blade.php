<?php
$url = "admin/badword";
$pagetitle = trans('messages.menu_bad_word');
?>
@extends('layouts.dashboard')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="glyphicon glyphicon-ban-circle"></i>')
@section('section')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>{{ trans('validation.attributes.censor_word')}}</strong>
                    </div>
                    <div class="panel-body">
                        {!! Form::open(['method'=>'POST','url'=>'admin/censor','class'=>''])  !!}
                        <div class="form-inline">
                            {!! Form::text('censor_word', $config->censor_word, array('placeholder' => trans('validation.attributes.censor_word'),'class' => 'form-control')) !!}
                            <button class="btn btn-primary" type="submit">
                                <span>บันทึก</span>
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>{{ trans('messages.menu_bad_word')}}</strong>
                    </div>
                    <div class="panel-body">

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
                        <p></p>

                        <p></p>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th width="60px" style="text-align:center;">{{ trans('messages.no') }}</th>
                                    <th>{{ trans('messages.menu_bad_word') }}</th>
                                    <th width="60px" style="text-align:center;"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($items as $key => $item)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $item->bad_word }}</td>
                                        <td style="text-align:center;">
                                            {!! Form::open(['method' => 'DELETE','route' => ['badword.destroy', $item->id],'style'=>'display:inline']) !!}
                                            <button onclick="return confirm('{{trans('messages.confirm_delete', ['attribute' => $item->product_question_th])}}');"
                                                    class="btn btn-danger" type="submit">
                                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                            </button>

                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        {!! $items->appends(Request::all()) !!}
                    </div>
                    <div class="panel-footer">
                        {!! Form::open(['method'=>'POST','url'=>'admin/badword','class'=>''])  !!}
                        <div class="form-inline">
                            <strong>{{ trans('messages.add_bad_word')}}</strong>
                            {!! Form::text('bad_word', null, array('placeholder' => trans('messages.menu_bad_word'),'class' => 'form-control')) !!}
                            <button class="btn btn-primary" type="submit">
                                <span>เพิ่ม</span>
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
