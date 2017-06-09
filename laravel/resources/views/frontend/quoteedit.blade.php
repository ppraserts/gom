@extends('layouts.main')
@section('page_heading',trans('message.menu_order_list'))
@section('page_heading_image','<i class="glyphicon glyphicon-apple"></i>')
@section('content')
    @include('shared.usermenu', array('setActive'=>'quote'))
    <div class="col-sm-12">

        <div class="row">

            <h2>{{ trans('messages.quotation_request') }}</h2>

            <div class="col-md-4">
                <div class="row">
                    <h3>{{ trans('messages.Description') }}</h3>
                    <p><b>{{ trans('messages.quotation_request_date') }} : </b>{{  $quotation->created_at }}</p>
                    <p><b>{{ trans('messages.i_buy') }} : </b>{{  $quotation->users_firstname_th . " " .$quotation->users_lastname_th }}</p>
                    @if(isset($quotation->users_mobilephone))
                    <p><b>{{ trans('validation.attributes.users_mobilephone') }} : </b>{{  $quotation->users_mobilephone }}</p>
                    @endif
                    @if(isset($quotation->users_phone))
                    <p><b>{{ trans('validation.attributes.users_phone') }} : </b>{{  $quotation->users_phone }}</p>
                    @endif

                </div>
            </div>

            <div class="col-md-4">
                <div class="row">
                    <h3>{{ trans('messages.i_want_to_buy') }}</h3>
                    <p><b>{{ trans('validation.attributes.product_name_th') }} : </b>{{  $quotation->product_name_th }}</p>
                    <p><b>{{ trans('validation.attributes.product_title') }} : </b>{{  $quotation->product_title }}</p>
                    <p><b>{{ trans('validation.attributes.volumn') }} : </b>{{  $quotation->volumnrange_start . " - " . $quotation->volumnrange_end . " " .$quotation->units }}</p>


                </div>
            </div>

            <div class="col-md-4">
                <div class="row">
                    <h3>{{trans('messages.menu_quotation_request')}}</h3>
                    {!! Form::model($quotation, ['method' => 'PATCH','route' => ['quote.update', $quotation->id] ,'files' => true]) !!}
                    <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                        <strong>* {{ trans('validation.attributes.price') }}:</strong>
                        {!! Form::number('price', null, array('placeholder' => trans('validation.attributes.price'),'class' => 'form-control')) !!}
                    </div>

                    {{--<div class="form-group {{ $errors->has('discount') ? 'has-error' : '' }}">
                        <strong>* {{ trans('validation.attributes.discount') }}:</strong>
                        {!! Form::number('discount', null, array('placeholder' => trans('validation.attributes.discount'),'class' => 'form-control')) !!}
                    </div>--}}

                    <button type="submit" class="btn btn-primary">
                        <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                        {{ trans('messages.send_quotation')}}</button>
                    {!! Form::close() !!}

                </div>
            </div>

        </div>


    </div>
@endsection