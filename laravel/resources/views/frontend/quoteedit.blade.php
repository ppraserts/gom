@extends('layouts.main')
@section('page_heading',trans('message.menu_order_list'))
@section('page_heading_image','<i class="glyphicon glyphicon-apple"></i>')
@section('content')
    @include('shared.usermenu', array('setActive'=>'quote'))
    <div class="col-sm-12">

        <div class="panel panel-default" style="margin-top: 15px;">
            <div class="panel-heading"><strong>{{ trans('messages.quotation_request') }}</strong></div>
            <div class="panel-body">

                <div class="col-md-6">
                    <div class="row">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th>{{ trans('messages.quotation_request_date') }}</th>
                                <th>{{ trans('messages.i_buy') }}</th>
                                @if(!empty($quotation->users_mobilephone))
                                    <th>{{ trans('validation.attributes.users_mobilephone') }}</th>
                                @endif
                                @if(!empty($quotation->users_phone))
                                    <th>{{ trans('validation.attributes.users_phone') }}</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    {{ \App\Helpers\DateFuncs::mysqlToThaiDate($quotation->created_at,true) }}
                                </td>
                                <td>{{  $quotation->users_firstname_th . " " .$quotation->users_lastname_th }}</td>
                                @if(!empty($quotation->users_mobilephone))
                                    <td>{{  $quotation->users_mobilephone }}</td>
                                @endif
                                @if(!empty($quotation->users_phone))
                                    <td>{{  $quotation->users_phone }}</td>
                                @endif
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <strong>{{ trans('messages.i_want_to_buy') }}</strong>
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th>{{ trans('validation.attributes.product_name_th') }}</th>
                                <th>{{ trans('validation.attributes.product_title') }}</th>
                                <th>{{ trans('validation.attributes.volumn') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{  $quotation->product_name_th }}</td>
                                <td>{{  $quotation->product_title }}</td>
                                <td>{{  $quotation->quantity ." ".$quotation->units }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-6">
                    {!! Form::model($quotation, ['method' => 'PATCH','route' => ['quote.update', $quotation->id] ,'files' => true,'data-toggle'=>'validator' ]) !!}
                    <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                        <strong>* {{ trans('messages.quote_price') }} ({{ trans('messages.baht') }}/{{ $quotation->units }}):</strong>
                        {!! Form::number('price', null, array('placeholder' => trans('validation.attributes.price'),'class' => 'form-control', 'min' => '1', 'data-error'=>trans('messages.please_input_price'))) !!}
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group {{ $errors->has('remark') ? 'has-error' : '' }}">
                        <strong>{{ trans('messages.remark') }}</strong>
                        {!! Form::textarea('remark', null, array('placeholder' => trans('messages.remark'),'class' => 'form-control')) !!}
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
@push('scripts')
<script src="{{url('bootstrap-validator/js/validator.js')}}"></script>
@endpush