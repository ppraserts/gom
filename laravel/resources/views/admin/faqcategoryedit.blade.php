<?php
$pagetitle = trans('messages.menu_faqcategory');

if($mode=="create")
{
  $method = "POST";
  $formModelId = 0;
  $controllerAction = "faqcategory.store";
}
else
{
  $method = "PATCH";
  $formModelId =  $item->id;
  $controllerAction = "faqcategory.update";
}
?>
@extends('layouts.dashboard')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="glyphicon glyphicon-question-sign"></i>')
@section('section')
<div class="col-sm-12">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h3>{{ trans('messages.addeditform') }}</h3>
            </div>
            <div class="pull-right">
                <a class="btn btn-default" href="{{ route('faqcategory.index') }}">
                  <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                   {{ trans('messages.button_back') }}</a>
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

    {!! Form::model($item, ['method' => $method,'route' => [$controllerAction, $formModelId]]) !!}

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('faqcategory_title_th') ? 'has-error' : '' }}">
                <strong>{{ Lang::get('validation.attributes.faqcategory_title_th') }}:</strong>
                {!! Form::text('faqcategory_title_th', null, array('placeholder' => Lang::get('validation.attributes.faqcategory_title_th'),'class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('faqcategory_description_th') ? 'has-error' : '' }}">
                <strong>{{ Lang::get('validation.attributes.faqcategory_description_th') }}:</strong>
                {!! Form::textarea('faqcategory_description_th', null, array('placeholder' => Lang::get('validation.attributes.faqcategory_description_th'),'class' => 'form-control','style'=>'height:100px')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('faqcategory_title_en') ? 'has-error' : '' }}">
                <strong>{{ Lang::get('validation.attributes.faqcategory_title_en') }}:</strong>
                {!! Form::text('faqcategory_title_en', null, array('placeholder' => Lang::get('validation.attributes.faqcategory_title_en'),'class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('faqcategory_description_en') ? 'has-error' : '' }}">
                <strong>{{ Lang::get('validation.attributes.faqcategory_description_en') }}:</strong>
                {!! Form::textarea('faqcategory_description_en', null, array('placeholder' => Lang::get('validation.attributes.faqcategory_description_en'),'class' => 'form-control','style'=>'height:100px')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('sequence') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label" style="padding-left: 0px;">
                  <strong>{{ Lang::get('validation.attributes.sequence') }}:</strong>
                </label>
                <div class="col-sm-2" style="padding-left: 0px;">
                {!! Form::number('sequence', null, array('placeholder' => Lang::get('validation.attributes.sequence'),'style' => 'text-align:center;','class' => 'form-control')) !!}
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12" >
                <button type="submit" class="btn btn-primary">
                  <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                  {{ trans('messages.button_save')}}</button>
        </div>

    </div>
    {!! Form::close() !!}
</div>
@endsection
