@extends('layouts.main')
@section('page_heading',trans('message.menu_order_list'))
@section('page_heading_image','<i class="glyphicon glyphicon-apple"></i>')
@section('content')
    @include('shared.usermenu', array('setActive'=>'quotation'))
    <div class="col-sm-12">

        <div class="row">

            <h2>{{ trans('messages.quotation') }}</h2>

            <div class="col-md-6">
                <div class="row">
                    <h3>{{ trans('messages.Description') }}</h3>
                    <p><b>{{ trans('messages.quotation_date') }} : </b>{{  \App\Helpers\DateFuncs::mysqlToThaiDate($quotation->updated_at) }}</p>
                    <p><b>{{ trans('messages.i_buy') }} : </b>{{  $quotation->users_firstname_th . " " .$quotation->users_lastname_th }}</p>
                    @if(isset($quotation->user->users_mobilephone))<p>
                        <b>{{ trans('validation.attributes.users_mobilephone') }}
                            : </b>{{ $quotation->user->users_mobilephone }}</p>@endif
                    @if(isset($quotation->user->users_phone))<p><b>{{ trans('validation.attributes.users_phone') }}
                            : </b>{{ $quotation->user->users_phone }}</p>@endif
                    @if(isset($quotation->user->email))<p><b>{{ trans('validation.attributes.email') }}
                            : </b>{{ $quotation->user->email }}</p>@endif
                    <p><b>{{ trans('validation.attributes.users_addressname') }}
                            : </b>{{ $quotation->user->users_addressname . " " . $quotation->user->users_district . " " . $quotation->user->users_city . " " . $quotation->user->users_province . " " . $quotation->user->users_postcode }}
                    </p>

                </div>
            </div>

            <div class="col-md-6">
                <div class="row">
                    <h3>{{ trans('messages.menu_product') }}</h3>
                    <p><b>{{ trans('validation.attributes.product_name_th') }} : </b>{{  $quotation->product_name_th }}</p>
                    <p><b>{{ trans('validation.attributes.product_title') }} : </b>{{  $quotation->product_title }}</p>
                    <p><b>{{ trans('validation.attributes.price') }} : </b>{{  $quotation->price. " " .$quotation->units }}</p>
                    <p><b>{{ trans('validation.attributes.discount') }} : </b>{{  $quotation->discount }}</p>

                </div>
            </div>



        </div>


    </div>
@endsection