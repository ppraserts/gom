<?php
$pagetitle = trans('messages.userprofile');

$method = "PATCH";
$controllerAction = "userprofile.update";
?>
@extends('layouts.dashboard')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="fa fa-user fa-fw"></i>')
@section('section')
<div class="col-sm-12">
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
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    {!! Form::model($item,['method' => $method,'route' => [$controllerAction, 0]]) !!}

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <strong>* {{ Lang::get('validation.attributes.name') }}:</strong>
                {!! Form::text('name', null, array('placeholder' => Lang::get('validation.attributes.name'),'class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <strong>* {{ Lang::get('validation.attributes.email') }}:</strong>
                {!! Form::text('email', null, array('placeholder' => Lang::get('validation.attributes.email'),'class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top:10px; margin-bottom:20px">
                <button type="submit" class="btn btn-primary">
                  <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                  {{ trans('messages.button_save')}}</button>
        </div>

    </div>
    {!! Form::close() !!}
</div>
@endsection
