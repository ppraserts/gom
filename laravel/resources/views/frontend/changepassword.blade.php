@extends('layouts.main')
@section('content')
@include('frontend.messages_element.shop_show_ms')
@include('shared.usermenu', array('setActive'=>'changepasswords'))
<br/>
<form enctype="multipart/form-data" class="form-horizontal" role="form" method="POST" action="{{ url('user/updatepasswords') }}">
{{ csrf_field() }}
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
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
            </div>
            <div class="pull-right">
                 <button type="submit" class="btn btn-primary">
                   <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                   {{ trans('messages.button_save')}}</button>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('now_password') ? 'has-error' : '' }}">
                <strong>* {{ Lang::get('validation.attributes.now_password') }}:</strong>
                {!! Form::text('now_password', null, array('placeholder' => Lang::get('validation.attributes.now_password'),'class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('new_password') ? 'has-error' : '' }}">
                <strong>* {{ Lang::get('validation.attributes.new_password') }}:</strong>
                {!! Form::text('new_password', null, array('placeholder' => Lang::get('validation.attributes.new_password'),'class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                <strong>* {{ Lang::get('validation.attributes.password_confirmation') }}:</strong>
                {!! Form::text('password_confirmation', null, array('placeholder' => Lang::get('validation.attributes.password_confirmation'),'class' => 'form-control')) !!}
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection
