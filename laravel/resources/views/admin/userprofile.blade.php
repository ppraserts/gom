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
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group {{ $errors->has('users_firstname_th') ? 'has-error' : '' }}">
                <strong>{{ Lang::get('validation.attributes.users_firstname_th') }}:</strong>
                {!! Form::text('users_firstname_th', null, array('placeholder' => Lang::get('validation.attributes.users_firstname_th'),'class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group {{ $errors->has('users_lastname_th') ? 'has-error' : '' }}">
                <strong>{{ Lang::get('validation.attributes.users_lastname_th') }}:</strong>
                {!! Form::text('users_lastname_th', null, array('placeholder' => Lang::get('validation.attributes.users_lastname_th'),'class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group {{ $errors->has('users_firstname_en') ? 'has-error' : '' }}">
                <strong>{{ Lang::get('validation.attributes.users_firstname_en') }}:</strong>
                {!! Form::text('users_firstname_en', null, array('placeholder' => Lang::get('validation.attributes.users_firstname_en'),'class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group {{ $errors->has('users_lastname_en') ? 'has-error' : '' }}">
                <strong>{{ Lang::get('validation.attributes.users_lastname_en') }}:</strong>
                {!! Form::text('users_lastname_en', null, array('placeholder' => Lang::get('validation.attributes.users_lastname_en'),'class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <strong>{{ Lang::get('validation.attributes.email') }}:</strong>
                {!! Form::text('email', null, array('placeholder' => Lang::get('validation.attributes.email'),'class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('users_phone') ? 'has-error' : '' }}">
                <strong>{{ Lang::get('validation.attributes.users_phone') }}:</strong>
                {!! Form::text('users_phone', null, array('placeholder' => Lang::get('validation.attributes.users_phone'),'class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('users_mobilephone') ? 'has-error' : '' }}">
                <strong>{{ Lang::get('validation.attributes.users_mobilephone') }}:</strong>
                {!! Form::text('users_mobilephone', null, array('placeholder' => Lang::get('validation.attributes.users_mobilephone'),'class' => 'form-control')) !!}
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
