<?php
$pagetitle = trans('messages.menu_aboutus');

$method = "PATCH";
$formModelId =  1;
$controllerAction = "aboutus.update";

?>
@extends('layouts.dashboard')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="glyphicon glyphicon-edit"></i>')
@section('section')
<div class="col-sm-12">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h3>{{ trans('messages.addeditform') }}</h3>
            </div>
        </div>
    </div>

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
    {!! Form::model($item, ['method' => $method,'route' => [$controllerAction, $formModelId]]) !!}

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('aboutus_description_th') ? 'has-error' : '' }}">
                <strong>{{ Lang::get('validation.attributes.aboutus_description_th') }}:</strong>
                {!! Form::textarea('aboutus_description_th', null, array('placeholder' => Lang::get('validation.attributes.aboutus_description_th'),'class' => 'form-control','style'=>'height:100px')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('aboutus_description_en') ? 'has-error' : '' }}">
                <strong>{{ Lang::get('validation.attributes.aboutus_description_en') }}:</strong>
                {!! Form::textarea('aboutus_description_en', null, array('placeholder' => Lang::get('validation.attributes.aboutus_description_en'),'class' => 'form-control','style'=>'height:100px')) !!}
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
