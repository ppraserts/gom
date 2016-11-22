<?php
$pagetitle = trans('messages.menu_contactus');

$method = "PATCH";
$formModelId =  1;
$controllerAction = "contactus.update";

?>
@extends('layouts.dashboard')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="glyphicon glyphicon-edit"></i>')
@push('scripts')
<script type="text/javascript">
  $(function() {
    var myLatLng = {lat: <?php echo $item->contactus_latitude; ?>, lng: <?php echo $item->contactus_longitude; ?>};

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
<div class="col-sm-12">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
        <ul class="nav nav-tabs">
            <li class="active"><a href="{{ url ('admin/contactus') }}" >{{ trans('messages.menu_contactusinfo') }}</a>
            </li>
            <li><a href="{{ url ('admin/contactusform') }}" >{{ trans('messages.menu_contactusform') }}</a>
            </li>
        </ul>
      </div>
    </div>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h3>{{ trans('messages.addeditform') }}</h3>
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
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    {!! Form::model($item, ['method' => $method,'route' => [$controllerAction, $formModelId]]) !!}

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('contactus_address_th') ? 'has-error' : '' }}">
                <strong>{{ Lang::get('validation.attributes.contactus_address_th') }}:</strong>
                {!! Form::textarea('contactus_address_th', null, array('placeholder' => Lang::get('validation.attributes.contactus_address_th'),'class' => 'form-control','style'=>'height:100px')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('contactus_address_en') ? 'has-error' : '' }}">
                <strong>{{ Lang::get('validation.attributes.contactus_address_en') }}:</strong>
                {!! Form::textarea('contactus_address_en', null, array('placeholder' => Lang::get('validation.attributes.contactus_address_en'),'class' => 'form-control','style'=>'height:100px')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12" style="display:none;">
            <div class="form-group {{ $errors->has('contactus_latitude') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label" style="padding-left: 0px;">
                  <strong>{{ Lang::get('validation.attributes.contactus_latitude') }}:</strong>
                </label>
                <div class="col-sm-2" style="padding-left: 0px;">
                {!! Form::text('contactus_latitude', null, array('placeholder' => Lang::get('validation.attributes.contactus_latitude'),'style' => 'text-align:center;','class' => 'form-control')) !!}
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12" style="display:none;">
            <div class="form-group {{ $errors->has('contactus_longitude') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label" style="padding-left: 0px;">
                  <strong>{{ Lang::get('validation.attributes.contactus_longitude') }}:</strong>
                </label>
                <div class="col-sm-2" style="padding-left: 0px;">
                {!! Form::text('contactus_longitude', null, array('placeholder' => Lang::get('validation.attributes.contactus_longitude'),'style' => 'text-align:center;','class' => 'form-control')) !!}
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top:10px; margin-bottom:20px; display:none;">
              <div id="map" style="width: 100%; height: 300px;"></div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top:10px; margin-bottom:20px">
                <button type="submit" class="btn btn-primary">
                  <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                  {{ trans('messages.button_save')}}</button>
        </div>

    </div>
    {!! Form::close() !!}
</div>
@endsection
