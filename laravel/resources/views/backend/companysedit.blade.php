<?php
$pagetitle = trans('messages.menu_user');

$method = "PATCH";
$formModelId =  $item->id;
$controllerAction = "companys.update";
?>
@extends('layouts.dashboard')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="fa fa-user fa-fw"></i>')
@push('scripts')
<script type="text/javascript">
  $(function() {
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
        $( "[name=contactus_latitude]" ).val(this.getPosition().lat());
        $( "[name=contactus_longitude]" ).val(this.getPosition().lng());
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
                <li >
                        <a href="{{ url ('admin/users') }}" >
                              {{ trans('messages.membertype_individual') }}
                              <span class="badge">{{ $countinactiveusers }}</span>
                        </a>
                </li>
                <li  class="active">
                        <a href="{{ url ('admin/companys') }}" >
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
                <a class="btn btn-default" href="{{ route('companys.index') }}">
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
            <div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
                {{ Lang::get('validation.attributes.is_active') }}
                :
                <strong>
                  <input value="1" type="checkbox" id="is_active" name="is_active" {{ $item->is_active == 0? '' : 'checked' }}>
                </strong>
            </div>
            <div class="form-group {{ $errors->has('iwantto') ? 'has-error' : '' }}">
                {{ Lang::get('validation.attributes.iwantto') }}
                :
                <strong>{{ $item->iwanttosale }} {{ $item->iwanttobuy}}</strong>
            </div>
            <div class="form-group {{ $errors->has('users_taxcode') ? 'has-error' : '' }}">
                {{ Lang::get('validation.attributes.users_taxcode') }}
                :
                <strong>{{ $item->users_taxcode }}</strong>
            </div>
            <div class="form-group {{ $errors->has('users_qrcode') ? 'has-error' : '' }}">
                {{ Lang::get('validation.attributes.users_qrcode') }}
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
            <div class="form-group {{ $errors->has('users_company_th') ? 'has-error' : '' }}">
                {{ Lang::get('validation.attributes.users_company_th') }}
                :
                <strong>{{ $item->users_company_th }}</strong>
            </div>
            <div class="form-group {{ $errors->has('users_company_en') ? 'has-error' : '' }}">
                {{ Lang::get('validation.attributes.users_company_en') }}
                :
                <strong>{{ $item->users_company_en }}</strong>
            </div>
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                {{ Lang::get('validation.attributes.email') }}
                :
                <strong>{{ $item->email }}</strong>
            </div>
            <div class="form-group {{ $errors->has('users_addressname') ? 'has-error' : '' }}">
                {{ Lang::get('validation.attributes.users_addressname') }}
                :
                <strong>{{ $item->users_addressname }}</strong>
            </div>
            <div class="form-group {{ $errors->has('users_street') ? 'has-error' : '' }}">
                {{ Lang::get('validation.attributes.users_street') }}
                :
                <strong>{{ $item->users_street }}</strong>
            </div>
            <div class="form-group {{ $errors->has('users_district') ? 'has-error' : '' }}">
                {{ Lang::get('validation.attributes.users_district') }}
                :
                <strong>{{ $item->users_district }}</strong>
            </div>
            <div class="form-group {{ $errors->has('users_city') ? 'has-error' : '' }}">
                {{ Lang::get('validation.attributes.users_city') }}
                :
                <strong>{{ $item->users_city }}</strong>
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group {{ $errors->has('users_province') ? 'has-error' : '' }}">
                {{ Lang::get('validation.attributes.users_province') }}
                :
                <strong>{{ $item->users_province }}</strong>
            </div>
            <div class="form-group {{ $errors->has('users_postcode') ? 'has-error' : '' }}">
                {{ Lang::get('validation.attributes.users_postcode') }}
                :
                <strong>{{ $item->users_postcode }}</strong>
            </div>
            <div class="form-group {{ $errors->has('users_mobilephone') ? 'has-error' : '' }}">
                {{ Lang::get('validation.attributes.users_mobilephone') }}
                :
                <strong>{{ $item->users_mobilephone }}</strong>
            </div>
            <div class="form-group {{ $errors->has('users_phone') ? 'has-error' : '' }}">
                {{ Lang::get('validation.attributes.users_phone') }}
                :
                <strong>{{ $item->users_phone }}</strong>
            </div>
            <div class="form-group {{ $errors->has('users_fax') ? 'has-error' : '' }}">
                {{ Lang::get('validation.attributes.users_fax') }}
                :
                <strong>{{ $item->users_fax }}</strong>
            </div>
            <div class="form-group" style="margin-top:10px; margin-bottom:20px; display:none;">
                  <div id="map" style="width: 100%; height: 300px;"></div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection
