<?php
$pagetitle = trans('messages.menu_slide_image');

if($mode=="create")
{
  $method = "POST";
  $formModelId = 0;
  $controllerAction = "slideimage.store";
}
else
{
  $method = "PATCH";
  $formModelId =  $item->id;
  $controllerAction = "slideimage.update";
}
?>
@extends('layouts.dashboard')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="glyphicon glyphicon-picture"></i>')
@section('section')
<div class="col-sm-12">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h3>{{ trans('messages.addeditform') }}</h3>
            </div>
            <div class="pull-right">
                <a class="btn btn-default" href="{{ route('slideimage.index') }}">
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

    {!! Form::model($item, ['method' => $method, 'files' => true ,'route' => [$controllerAction, $formModelId]]) !!}

    <div class="row">
        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group {{ $errors->has('slideimage_type') ? 'has-error' : '' }}">
                <strong>{{ Lang::get('validation.attributes.slideimage_type') }}:</strong>
                {!! Form::select('slideimage_type', $slideType, null, array('placeholder' => Lang::get('validation.attributes.slideimage_type'),'class' => 'form-control')); !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('slideimage_name') ? 'has-error' : '' }}">
                <strong>{{ Lang::get('validation.attributes.slideimage_name') }}:</strong>
                {!! Form::text('slideimage_name', null, array('placeholder' => Lang::get('validation.attributes.slideimage_name'),'class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('slideimage_file') ? 'has-error' : '' }}">
                <strong>{{ Lang::get('validation.attributes.slideimage_file') }}:</strong>
                {!! Form::file('slideimage_file', null, array('placeholder' => Lang::get('validation.attributes.slideimage_file'),'class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('slideimage_urllink') ? 'has-error' : '' }}">
                <strong>{{ Lang::get('validation.attributes.slideimage_urllink') }}:</strong>
                {!! Form::text('slideimage_urllink', null, array('placeholder' => Lang::get('validation.attributes.slideimage_urllink'),'class' => 'form-control')) !!}
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
        <?php
          if($mode=="edit")
          {
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12">
            {!! Html::image($item->slideimage_file,null,array('class' => 'img-thumbnail', 'width' => '304', 'height'=>'236')) !!}
        </div>
        <?php
          }
        ?>

        <div class="col-xs-12 col-sm-12 col-md-12">
                {{ Form::hidden('slideimage_file_temp', $item->slideimage_file) }}
                <button type="submit" class="btn btn-primary">
                  <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                  {{ trans('messages.button_save')}}</button>
        </div>

    </div>
    {!! Form::close() !!}
</div>
@endsection
