<?php
$pagetitle = trans('messages.menu_adminteam');

if($mode=="create")
{
  $method = "POST";
  $formModelId = 0;
  $controllerAction = "adminteam.store";
}
else
{
  $method = "PATCH";
  $formModelId =  $item->id;
  $controllerAction = "adminteam.update";
}
?>
@extends('layouts.dashboard')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="glyphicon glyphicon-user"></i>')
@section('section')
<div class="col-sm-12">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h3>{{ trans('messages.addeditform') }}</h3>
            </div>
            <div class="pull-right">
                <a class="btn btn-default" href="{{ route('adminteam.index') }}">
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

    <div class="row" style="margin-bottom:15px;">

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

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <strong>* {{ Lang::get('validation.attributes.password') }}:</strong>
                <input placeholder="{{ Lang::get('validation.attributes.password') }}" class="form-control" name="password" type="text" value="">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12" style="margin-bottom:15px;">

              <input {{ (strpos($item->allow_menu, 'menu_user') !== false)? 'checked' : '' }} type="checkbox" name='chkallow_menu[]' value="menu_user"> {{ trans('messages.menu_user') }}
              <br/>
              <input {{ (strpos($item->allow_menu, 'menu_market') !== false)? 'checked' : '' }} type="checkbox" name='chkallow_menu[]' value="menu_market"> {{ trans('messages.menu_market') }}
              <br/>
              <input {{ (strpos($item->allow_menu, 'menu_product_category') !== false)? 'checked' : '' }} type="checkbox" name='chkallow_menu[]' value="menu_product_category"> {{ trans('messages.menu_product_category') }}
              <br/>
              <input {{ (strpos($item->allow_menu, 'menu_slide_image') !== false)? 'checked' : '' }} type="checkbox" name='chkallow_menu[]' value="menu_slide_image"> {{ trans('messages.menu_slide_image') }}
              <br/>
              <input {{ (strpos($item->allow_menu, 'menu_download_document') !== false)? 'checked' : '' }} type="checkbox" name='chkallow_menu[]' value="menu_download_document"> {{ trans('messages.menu_download_document') }}
              <br/>
              <input {{ (strpos($item->allow_menu, 'menu_bad_word') !== false)? 'checked' : '' }} type="checkbox" name='chkallow_menu[]' value="menu_bad_word"> {{ trans('messages.menu_bad_word') }}
              <br/>
              <input {{ (strpos($item->allow_menu, 'menu_aboutus') !== false)? 'checked' : '' }} type="checkbox" name='chkallow_menu[]' value="menu_aboutus"> {{ trans('messages.menu_aboutus') }}
              <br/>
              <input {{ (strpos($item->allow_menu, 'menu_contactus') !== false)? 'checked' : '' }} type="checkbox" name='chkallow_menu[]' value="menu_contactus"> {{ trans('messages.menu_contactus') }}
              <br/>
              <input {{ (strpos($item->allow_menu, 'menu_faq') !== false)? 'checked' : '' }} type="checkbox" name='chkallow_menu[]' value="menu_faq"> {{ trans('messages.menu_faq') }}
              <br/>
              <input {{ (strpos($item->allow_menu, 'menu_media') !== false)? 'checked' : '' }} type="checkbox" name='chkallow_menu[]' value="menu_media"> {{ trans('messages.menu_media') }}
              <br/>
              <input {{ (strpos($item->allow_menu, 'menu_news') !== false)? 'checked' : '' }} type="checkbox" name='chkallow_menu[]' value="menu_news"> {{ trans('messages.menu_news') }}
              <br/>
              <input {{ (strpos($item->allow_menu, 'menu_report') !== false)? 'checked' : '' }} type="checkbox" name='chkallow_menu[]' value="menu_report"> {{ trans('messages.menu_report') }}
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
