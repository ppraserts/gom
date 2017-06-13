<?php
$pagetitle = trans('messages.menu_user');

$method = "PATCH";
$formModelId = $item->id;
$controllerAction = "users.update";
?>
@extends('layouts.dashboard')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="fa fa-user fa-fw"></i>')
@push('scripts')
<script type="text/javascript">
    $(function () {
        var myLatLng = {lat: <?php echo $item->users_latitude; ?>, lng: <?php echo $item->users_longitude; ?>};

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: myLatLng
        });

        var marker = new google.maps.Marker({
            position: myLatLng,
            draggable: true,
            animation: google.maps.Animation.DROP,
            map: map,
            title: 'Hello World!'
        });

        google.maps.event.addListener(marker, 'dragend', function (event) {
            $("[name=contactus_latitude]").val(this.getPosition().lat());
            $("[name=contactus_longitude]").val(this.getPosition().lng());
        });
    })
</script>
@endpush
@section('section')
    {!! Form::model($item, ['method' => $method,'route' => [$controllerAction, $formModelId]]) !!}
    <div class="col-sm-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="{{ url ('admin/users') }}">
                            {{ trans('messages.membertype_individual') }}
                            <span class="badge">{{ $countinactiveusers }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url ('admin/companys') }}">
                            {{ trans('messages.membertype_company') }}
                            <span class="badge">{{ $countinactivecompanyusers }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                </div>
                <div class="pull-right">
                    <a class="btn btn-default" href="{{ route('users.index') }}">
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
            <div class="col-xs-6 col-sm-6 col-md-6">
                @if($item->users_imageprofile != "")
                    <img height="150" width="150" src="{{ url($item->users_imageprofile) }}" alt="" class="img-circle">
                @endif
                <div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
                    {{ trans('validation.attributes.is_active') }}
                    :
                    <strong>
                        <input value="1" type="checkbox" id="is_active"
                               name="is_active" {{ $item->is_active == 0? '' : 'checked' }}>
                    </strong>
                </div>
                @if($item->iwanttosale=='sale')
                    <div class="form-group form-inline">
                        <span> {{ trans('validation.attributes.market') }} :</span>
                        <div>
                            @for($i = 0 ; $i < count($markets) ; $i++)
                                {{--<label class="checkbox-inline">--}}
                                <input name="markets[]" type="checkbox"
                                       value="{{ $markets[$i]->id}}"
                                       {{ $markets[$i]->checked ? "checked" : ""}} style="margin-left: 10px;">
                                {{$markets[$i]->market_title_th}} <br>
                                {{--</label>--}}
                            @endfor
                        </div>
                    </div>
                @endif
                <div class="form-group {{ $errors->has('iwantto') ? 'has-error' : '' }}">
                    {{ trans('validation.attributes.iwantto') }}
                    :
                    <strong>{{ $item->iwanttosale }} {{ $item->iwanttobuy }}</strong>
                </div>
                <div class="form-group {{ $errors->has('users_idcard') ? 'has-error' : '' }}">
                    {{ trans('validation.attributes.users_idcard') }}
                    :
                    <strong>{{ $item->users_idcard }}</strong>
                </div>
                <div class="form-group {{ $errors->has('users_qrcode') ? 'has-error' : '' }}">
                    {{ trans('validation.attributes.users_qrcode') }}
                    :
                    <strong>{{ $item->users_qrcode }}</strong>
                </div>
                <div class="form-group {{ $errors->has('users_standard') ? 'has-error' : '' }}">
                    {{ trans('validation.attributes.guarantee') }}
                    :
                    <strong>
                        @if($standard!=null)
                            {{$standard}}
                        @else
                            -
                        @endif
                    </strong>
                </div>
                <div class="form-group {{ $errors->has('users_firstname_th') ? 'has-error' : '' }}">
                    {{ trans('validation.attributes.users_firstname_th') }} -
                    {{ trans('validation.attributes.users_lastname_th') }}
                    :
                    <strong>{{ $item->users_firstname_th }}  {{ $item->users_lastname_th }}</strong>
                </div>
                <div class="form-group {{ $errors->has('users_firstname_en') ? 'has-error' : '' }}">
                    {{ trans('validation.attributes.users_firstname_en') }} -
                    {{ trans('validation.attributes.users_lastname_en') }}
                    :
                    <strong>{{ $item->users_firstname_en }}  {{ $item->users_lastname_en }}</strong>
                </div>
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    {{ trans('validation.attributes.email') }}
                    :
                    <strong>{{ $item->email }}</strong>
                </div>
                <div class="form-group {{ $errors->has('users_dateofbirth') ? 'has-error' : '' }}">
                    {{ trans('validation.attributes.users_dateofbirth') }}
                    :
                    <strong>{{ DateFuncs::thai_date($item->users_dateofbirth) }}</strong>
                </div>
                <div class="form-group {{ $errors->has('users_gender') ? 'has-error' : '' }}">
                    {{ trans('validation.attributes.users_gender') }}
                    :
                    <strong>{{ $item->users_gender == 'male'? trans('messages.gender_male') : trans('messages.gender_female') }}</strong>
                </div>
                <div class="form-group {{ $errors->has('users_addressname') ? 'has-error' : '' }}">
                    {{ trans('validation.attributes.users_addressname') }}
                    :
                    <strong>{{ $item->users_addressname }}</strong>
                </div>
                <div class="form-group {{ $errors->has('users_street') ? 'has-error' : '' }}">
                    {{ trans('validation.attributes.users_street') }}
                    :
                    <strong>{{ $item->users_street }}</strong>
                </div>
                <div class="form-group {{ $errors->has('users_district') ? 'has-error' : '' }}">
                    {{ trans('validation.attributes.users_district') }}
                    :
                    <strong>{{ $item->users_district }}</strong>
                </div>
                <div class="form-group {{ $errors->has('users_city') ? 'has-error' : '' }}">
                    {{ trans('validation.attributes.users_city') }}
                    :
                    <strong>{{ $item->users_city }}</strong>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group {{ $errors->has('users_province') ? 'has-error' : '' }}">
                    {{ trans('validation.attributes.users_province') }}
                    :
                    <strong>{{ $item->users_province }}</strong>
                </div>
                <div class="form-group {{ $errors->has('users_postcode') ? 'has-error' : '' }}">
                    {{ trans('validation.attributes.users_postcode') }}
                    :
                    <strong>{{ $item->users_postcode }}</strong>
                </div>
                <div class="form-group {{ $errors->has('users_mobilephone') ? 'has-error' : '' }}">
                    {{ trans('validation.attributes.users_mobilephone') }}
                    :
                    <strong>{{ $item->users_mobilephone }}</strong>
                </div>
                <div class="form-group {{ $errors->has('users_phone') ? 'has-error' : '' }}">
                    {{ trans('validation.attributes.users_phone') }}
                    :
                    <strong>{{ $item->users_phone }}</strong>
                </div>
                <div class="form-group" style="margin-top:10px; margin-bottom:20px; display:none;">
                    <div id="map" style="width: 100%; height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
