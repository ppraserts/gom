<?php
$pagetitle = trans('messages.menu_news');

if($mode=="create")
{
  $method = "POST";
  $formModelId = 0;
  $controllerAction = "news.store";
}
else
{
  $method = "PATCH";
  $formModelId =  $item->id;
  $controllerAction = "news.update";
}
?>
@extends('layouts.dashboard')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="glyphicon glyphicon-bullhorn"></i>')
@push('scripts')
<script type="text/javascript">
    $(function() {
            $(document).on("keypress", "form", function(event) {
                return event.keyCode != 13;
            });

            $('#datetimepicker1').datetimepicker({
                format: 'YYYY-MM-DD'
            });
    });
</script>
@endpush
@section('section')
{!! Form::model($item, ['method' => $method,'files' => true ,'route' => [$controllerAction, $formModelId]]) !!}
{{ Form::hidden('news_document_file_temp', $item->news_document_file) }}
<div class="col-sm-12" style="margin-bottom:15px !important;">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h3>{{ trans('messages.addeditform') }}</h3>
            </div>
            <div class="pull-right">
                <a class="btn btn-default" href="{{ route('news.index') }}">
                  <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                   {{ trans('messages.button_back') }}</a>

                <button type="submit" class="btn btn-primary">
                  <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                  {{ trans('messages.button_save')}}</button>
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
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12" style="display:none;">
            <div class="form-group {{ $errors->has('news_tags') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label" style="padding-left: 0px;">
                  <strong>* {{ Lang::get('validation.attributes.news_tags') }}:</strong>
                </label>
                <div class="col-sm-4" style="padding-left: 0px;">
                {!! Form::text('news_tags', null, array('placeholder' => Lang::get('validation.attributes.news_tags'),'class' => 'form-control', 'data-role'=> 'tagsinput')) !!}
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('news_title_th') ? 'has-error' : '' }}">
                <strong>* {{ Lang::get('validation.attributes.news_title_th') }}:</strong>
                {!! Form::text('news_title_th', null, array('placeholder' => Lang::get('validation.attributes.news_title_th'),'class' => 'form-control' )) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('news_description_th') ? 'has-error' : '' }}">
                <strong>* {{ Lang::get('validation.attributes.news_description_th') }}:</strong>
                {!! Form::textarea('news_description_th', null, array('placeholder' => Lang::get('validation.attributes.news_description_th'),'class' => 'form-control','style'=>'height:100px')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('news_title_en') ? 'has-error' : '' }}">
                <strong>* {{ Lang::get('validation.attributes.news_title_en') }}:</strong>
                {!! Form::text('news_title_en', null, array('placeholder' => Lang::get('validation.attributes.news_title_en'),'class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('news_description_en') ? 'has-error' : '' }}">
                <strong>* {{ Lang::get('validation.attributes.news_description_en') }}:</strong>
                {!! Form::textarea('news_description_en', null, array('placeholder' => Lang::get('validation.attributes.news_description_en'),'class' => 'form-control','style'=>'height:100px')) !!}
            </div>
        </div>

         <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('news_document_file') ? 'has-error' : '' }}">
                <strong>{{ Lang::get('validation.attributes.news_document_file') }}:</strong>
                {!! Form::file('news_document_file', null, array('placeholder' => Lang::get('validation.attributes.news_document_file'),'class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('news_created_at') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label" style="padding-left: 0px;">
                  <strong>* {{ Lang::get('validation.attributes.news_created_at') }}:</strong>
                </label>
                <div class="col-sm-4" style="padding-left: 0px;">
                        <div class='input-group date' id='datetimepicker1'>
                {!! Form::text('news_created_at', null, array('placeholder' => Lang::get('validation.attributes.news_created_at'),'class' => 'form-control')) !!}
                                <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                        </div>
                </div>
            </div>
        </div>

         <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('news_place') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label" style="padding-left: 0px;">
                  <strong>* {{ Lang::get('validation.attributes.news_place') }}:</strong>
                </label>
                <div class="col-sm-4" style="padding-left: 0px;">
                {!! Form::text('news_place', null, array('placeholder' => Lang::get('validation.attributes.news_place'),'class' => 'form-control')) !!}
                </div>
            </div>
        </div>

         <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('news_sponsor') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label" style="padding-left: 0px;">
                  <strong>* {{ Lang::get('validation.attributes.news_sponsor') }}:</strong>
                </label>
                <div class="col-sm-4" style="padding-left: 0px;">
                {!! Form::text('news_sponsor', null, array('placeholder' => Lang::get('validation.attributes.news_sponsor'),'class' => 'form-control')) !!}
                </div>
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
        @for($i=1;$i<=5;$i++)
        <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group {{ $errors->has('news_sponsor') ? 'has-error' : '' }}">
            <label class="col-sm-2 control-label" style="padding-left: 0px;">
              <strong>Default Image {{ $i }}:</strong>
            </label>
            <div class="col-sm-4" style="padding-left: 0px;">
              <input type="text" class="form-control" value="{{ url('/upload/defaultnews/'.$i.'.png') }}">
            </div>
            <div class="col-sm-4" style="padding-left: 0px;">
              <a target="_new" href="{{ url('/upload/defaultnews/'.$i.'.png') }}">View</a>
            </div>
          </div>
        </div>
        @endfor

        @if($item->news_document_file!="")
                <div class="col-xs-12 col-sm-12 col-md-12">
                <a class="btn btn-success btn-small navbar-btn" href="{{ url($item->news_document_file) }}"><span class="glyphicon glyphicon-hdd" aria-hidden="true"></span> {{  Lang::get('validation.attributes.news_document_file') }}</a>
                </div>
        @endif
    </div>
</div>
{!! Form::close() !!}
@endsection
