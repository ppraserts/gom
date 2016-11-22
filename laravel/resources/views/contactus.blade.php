@extends('layouts.main')
@push('scripts')
<script src="//maps.google.com/maps/api/js?key=AIzaSyCTyLJemFK5wu_ONI1iZobLGK9pP1EVReo"></script>
<script type="text/javascript">
  $(function() {
    var myLatLng = {lat: {{ $contactusItem->contactus_latitude }}, lng: {{ $contactusItem->contactus_longitude}} };

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
@section('content')
<div class="row">
  <div class="col-md-6">
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
    <form  role="form" method="POST" action="{{ url('/contactus') }}">
       {{ csrf_field() }}
           <div class="form-group {{ $errors->has('contactusform_name') ? 'has-error' : '' }}">
               <strong>{{ Lang::get('validation.attributes.contactusform_name') }}:</strong>
               {!! Form::text('contactusform_name', null, array('placeholder' => Lang::get('validation.attributes.contactusform_name'),'class' => 'form-control')) !!}
           </div>

           <div class="form-group {{ $errors->has('contactusform_surname') ? 'has-error' : '' }}">
               <strong>{{ Lang::get('validation.attributes.contactusform_surname') }}:</strong>
               {!! Form::text('contactusform_surname', null, array('placeholder' => Lang::get('validation.attributes.contactusform_surname'),'class' => 'form-control')) !!}
           </div>

           <div class="form-group {{ $errors->has('contactusform_phone') ? 'has-error' : '' }}">
               <strong>{{ Lang::get('validation.attributes.contactusform_phone') }}:</strong>
               {!! Form::text('contactusform_phone', null, array('placeholder' => Lang::get('validation.attributes.contactusform_phone'),'class' => 'form-control')) !!}
           </div>

           <div class="form-group {{ $errors->has('contactusform_email') ? 'has-error' : '' }}">
               <strong>{{ Lang::get('validation.attributes.contactusform_email') }}:</strong>
               {!! Form::text('contactusform_email', null, array('placeholder' => Lang::get('validation.attributes.contactusform_email'),'class' => 'form-control')) !!}
           </div>

           <div class="form-group {{ $errors->has('contactusform_subject') ? 'has-error' : '' }}">
               <strong>{{ Lang::get('validation.attributes.contactusform_subject') }}:</strong>
               {!! Form::text('contactusform_subject', null, array('placeholder' => Lang::get('validation.attributes.contactusform_subject'),'class' => 'form-control')) !!}
           </div>

           <div class="form-group {{ $errors->has('contactusform_messagebox') ? 'has-error' : '' }}">
               <strong>{{ Lang::get('validation.attributes.contactusform_messagebox') }}:</strong>
               {!! Form::textarea('contactusform_messagebox', null, array('placeholder' => Lang::get('validation.attributes.contactusform_messagebox'),'class' => 'form-control','style'=>'height:100px')) !!}
           </div>

           <div class="form-group{{ $errors->has('CaptchaCode') ? ' has-error' : '' }}">
              <div class="col-md-4">
                <label class="control-label">Captcha</label>
              </div>
              <div class="col-md-8">
                  {!! captcha_image_html('ContactCaptcha') !!}
                  <input class="form-control" type="text" id="CaptchaCode" name="CaptchaCode" style="margin-top:5px;">

                  @if ($errors->has('CaptchaCode'))
                      <span class="help-block">
                          <strong>{{ $errors->first('CaptchaCode') }}</strong>
                      </span>
                  @endif
              </div>
          </div>
      {{ Form::hidden('contactusform_file', $item->contactusform_file) }}
      <button type="submit" class="btn btn-primary">
        <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
        {{ trans('messages.button_save')}}</button>

    </form>
  </div>
  <div class="col-md-6">
      {!! $contactusItem->{ "contactus_address_".Lang::locale()} !!}
      <div style="display:none;" id="map" style="width: 100%; height: 300px;"></div>
  </div>
</div>
 @stop
