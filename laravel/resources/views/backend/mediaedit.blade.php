<?php
$pagetitle = trans('messages.menu_media');

if($mode=="create")
{
  $method = "POST";
  $formModelId = 0;
  $controllerAction = "media.store";
}
else
{
  $method = "PATCH";
  $formModelId =  $item->id;
  $controllerAction = "media.update";
}
?>
@extends('layouts.dashboard')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="glyphicon glyphicon-facetime-video"></i>')
@section('section')
<div class="col-sm-12">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h3>{{ trans('messages.addeditform') }}</h3>
            </div>
            <div class="pull-right">
                <a class="btn btn-default" href="{{ route('media.index') }}">
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
            <div class="form-group {{ $errors->has('media_name_th') ? 'has-error' : '' }}">
                <strong>* {{ Lang::get('validation.attributes.media_name_th') }}:</strong>
                {!! Form::text('media_name_th', null, array('placeholder' => Lang::get('validation.attributes.media_name_th'),'class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('media_name_en') ? 'has-error' : '' }}">
                <strong>* {{ Lang::get('validation.attributes.media_name_en') }}:</strong>
                {!! Form::text('media_name_en', null, array('placeholder' => Lang::get('validation.attributes.media_name_en'),'class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('media_urllink') ? 'has-error' : '' }}">
                <strong>* {{ Lang::get('validation.attributes.media_urllink') }}:</strong>
                {!! Form::text('media_urllink', null, array('placeholder' => Lang::get('validation.attributes.media_urllink'),'class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('sequence') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label" style="padding-left: 0px;">
                  <strong>* {{ Lang::get('validation.attributes.sequence') }}:</strong>
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
        <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top:10px; margin-bottom:10px;">
            <div class="embed-responsive embed-responsive-16by9" >
              <iframe class="embed-responsive-item" src="{{ $item->media_urllink }}"></iframe>
            </div>
        </div>
        <?php
          }
        ?>

        <div class="col-xs-12 col-sm-12 col-md-12" >
                <button type="submit" class="btn btn-primary">
                  <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                  {{ trans('messages.button_save')}}</button>
        </div>

    </div>
    {!! Form::close() !!}
</div>
@endsection
