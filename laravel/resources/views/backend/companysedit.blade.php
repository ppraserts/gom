<?php
$pagetitle = trans('messages.menu_user');

$method = "PATCH";
$formModelId = $item->id;
$controllerAction = "companys.update";
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
        });

        $('#users_province').on('change', function (e) {
            var state_id = e.target.value;
            $.get('{{ url('information') }}/create/ajax-state?province_id=' + state_id, function (data) {
                console.log(data);
                var option = '';
                $('#users_city').empty();
                $('#users_district').empty();
                $.each(data, function (index, subCatObj) {
                    option += '<option value="' + subCatObj.AMPHUR_NAME + '">' + subCatObj.AMPHUR_NAME + '</option>';
                });
                $('#users_city').append(option);
                $("#users_city").val('{{ old('users_city') }}');
                $("#users_city").trigger("change");
            });
        });

        $('#users_city').on('change', function (e) {
            var state_id = e.target.value;
            $.get('{{ url('information') }}/create/ajax-state?city_id=' + state_id, function (data) {
                console.log(data);
                var option = '';
                $('#users_district').empty();
                $.each(data, function (index, subCatObj) {
                    option += '<option value="' + subCatObj.DISTRICT_NAME + '">' + subCatObj.DISTRICT_NAME + '</option>';
                });
                $('#users_district').append(option);
                $("#users_district").val('{{ old('users_district') }}');
            });
        });
    </script>
@endpush
@section('section')
    {!! Form::model($item, ['method' => $method,'route' => [$controllerAction, $formModelId]]) !!}
    <div class="col-sm-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <ul class="nav nav-tabs">
                    <li>
                        <a href="{{ url ('admin/users') }}">
                            {{ trans('messages.membertype_individual') }}
                            <span class="badge">{{ $countinactiveusers }}</span>
                        </a>
                    </li>
                    <li class="active">
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
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h4 class="text-center">{{ trans('messages.membertype_company') }}</h4>
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
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="panel panel-default" style="margin-top:10px;">
                    <div class="panel-body">
                        @if($item->users_imageprofile != "")
                            <img height="150" width="150" src="{{ url($item->users_imageprofile) }}" alt=""
                                 class="img-circle">
                        @endif
                        <div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
                            <strong>{{ trans('validation.attributes.is_active') }}:</strong>
                            <input value="1" type="checkbox" id="is_active"
                                   name="is_active" {{ $item->is_active == 0? '' : 'checked' }}>
                        </div>
                        @if($item->iwanttosale=='sale')
                            <div class="form-group form-inline">
                                <strong> {{ trans('validation.attributes.market') }}:</strong>
                                <div>
                                    @for($i = 0 ; $i < count($markets) ; $i++)
                                        <input name="markets[]" type="checkbox"
                                               value="{{ $markets[$i]->id}}"
                                               {{ $markets[$i]->checked ? "checked" : ""}} style="margin-left: 10px;">
                                        {{$markets[$i]->market_title_th}} <br>
                                    @endfor
                                </div>
                            </div>
                        @endif
                        <div class="col-md-12 form-group {{ $errors->has('iwantto') ? 'has-error' : '' }}">
                            <strong>{{ trans('validation.attributes.iwantto') }}:</strong>
                            <input type="checkbox" name="iwanttosale" value="{{ $item->iwanttosale }}"
                                   @if($item->iwanttosale == 'sale') checked @endif> sale
                            <input type="checkbox" name="iwanttobuy" value="{{ $item->iwanttobuy }}"
                                   @if($item->iwanttobuy == 'buy')checked @endif> Buy
                        </div>
                        @if($item->iwanttosale == 'sale')
                            <div class="col-md-12 form-group {{ $errors->has('users_standard') ? 'has-error' : '' }}">
                                <strong>{{ trans('validation.attributes.guarantee') }}:</strong><br/>
                                @foreach($standard_all as $v)
                                    <input type="checkbox" name="standard[]" value="{{$v->id}}"
                                           @if(in_array($v->id, $standard)) checked @endif> {{$v->name}}<br/>
                                @endforeach
                                อื่นๆ <input type="text" name="other_standard" value="{{$item->other_standard}}">

                            </div>
                        @endif
                        <div class="col-md-6 form-group {{ $errors->has('users_idcard') ? 'has-error' : '' }}">
                            <strong>{{ Lang::get('validation.attributes.users_taxcode') }}:</strong>
                            <input type="text" class="form-control" name="users_taxcode"
                                   value="{{ $item->users_taxcode }}">
                        </div>
                        @if($item->iwanttosale == 'sale')
                            <div class="col-md-6 form-group {{ $errors->has('users_qrcode') ? 'has-error' : '' }}">
                                <strong>{{ trans('validation.attributes.users_qrcode') }}:</strong>
                                <input type="text" name="users_qrcode" class="form-control"
                                       value="{{ $item->users_qrcode }}">
                            </div>
                        @endif

                            <div class="col-md-6 form-group {{ $errors->has('users_company_th') ? 'has-error' : '' }}">
                                <strong>{{ Lang::get('validation.attributes.users_company_th') }}:</strong>
                                <input type="text" name="users_company_th" class="form-control"
                                       value="{{$item->users_company_th}}">
                            </div>

                        <div class="col-md-6 form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <strong>{{ trans('validation.attributes.email') }}:</strong>
                            <input type="email" name="email" class="form-control" value="{{$item->email}}">
                        </div>

                        <div class="col-md-6 form-group {{ $errors->has('users_addressname') ? 'has-error' : '' }}">
                            <label for="users_addressname" class="control-label">
                                <strong>{{ trans('validation.attributes.users_addressname') }}:</strong>
                            </label>
                            <input id="users_addressname" type="text" class="form-control"
                                   name="users_addressname" value="{{$item->users_addressname}}">

                            @if ($errors->has('users_addressname'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('users_addressname') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 form-group {{ $errors->has('users_province') ? ' has-error' : '' }}">
                            <label for="users_province" class="control-label">
                                <strong>* {{ Lang::get('validation.attributes.users_province') }}:</strong>
                            </label>

                            <select id="users_province" name="users_province" class="form-control" required>
                                <option value="">{{ trans('messages.please_select') }}</option>
                                @foreach ($provinceItem as $province)
                                    <option value="{{ $province->PROVINCE_NAME }}"
                                            @if($province->PROVINCE_NAME ==  $item->users_province)selected @endif>
                                        {{ $province->PROVINCE_NAME}}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('users_province'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('users_province') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 form-group{{ $errors->has('users_city') ? ' has-error' : '' }}">
                            <label for="users_city" class="control-label">
                                <strong>{{ Lang::get('validation.attributes.users_city') }}:</strong>
                            </label>
                            <select id="users_city" name="users_city" class="form-control">
                                @foreach($amphurs as $amphur)
                                    <option value="{{$amphur->AMPHUR_NAME}}"
                                            @if($amphur->AMPHUR_NAME == $item->users_city) selected @endif>
                                        {{$amphur->AMPHUR_NAME}}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('users_city'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('users_city') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 form-group{{ $errors->has('users_district') ? ' has-error' : '' }}">
                            <label for="users_district" class="control-label">
                                <strong>{{ Lang::get('validation.attributes.users_district') }}:</strong>
                            </label>
                            <select id="users_district" name="users_district" class="form-control">
                                @foreach($districts as $district)
                                    <option value="{{$district->DISTRICT_NAME}}"
                                            @if($district->DISTRICT_NAME == $item->users_district) selected @endif>
                                        {{$district->DISTRICT_NAME}}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('users_district'))
                                <span class="help-block">
                                    <strong>
                                        {{ $errors->first('users_district') }}
                                    </strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 form-group{{ $errors->has('users_postcode') ? ' has-error' : '' }}">
                            <label for="users_postcode" class="control-label">
                                <strong>{{ Lang::get('validation.attributes.users_postcode') }}:</strong>
                            </label>
                            <input type="text" class="form-control" name="users_postcode"
                                   value="{{$item->users_postcode}}">
                            @if ($errors->has('users_postcode'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('users_postcode') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 form-group {{ $errors->has('users_mobilephone') ? 'has-error' : '' }}">
                            <strong>{{ trans('validation.attributes.users_mobilephone') }}:</strong>
                            <input type="text" class="form-control" name="users_mobilephone"
                                   value="{{ $item->users_mobilephone }}">
                        </div>

                    </div>
                </div>
            </div>
            {{--//reset Password--}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group" style="margin-top:10px; margin-bottom:10px; display:none;">
                    <div id="map" style="width: 100%; min-height: 300px;"></div>
                </div>
                <div class="panel panel-default" style="margin-top:10px;">
                    <div class="panel-heading">{{ trans('messages.resetpassword_title') }}</div>
                    <div class="panel-body">
                        <form class="form-inline">
                            <div class="form-group">
                                <label class="sr-only" for="password">{{ trans('messages.password') }}</label>
                                <input type="text" class="form-control copy" id="password"
                                       data-clipboard-target="#password" readonly>
                            </div>
                            <button type="button" class="btn btn-primary" data-userid="{{ $item->id }}"
                                    data-toggle="modal"
                                    data-target="#password_confirm">{{ trans('messages.resetpassword_btn') }}</button>
                            <!--<button type="button" class="btn copy btn-default" data-clipboard-target="#password">Copy</button>-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    @push('scripts')
        <div class="modal fade" id="password_confirm" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">{{ trans('messages.resetpassword_title') }}</h4>
                    </div>
                    <div class="modal-body">
                        <p style="color:red;">{!! trans('messages.confirm_password_change') !!}</p>
                        <input type="hidden" id="change_password_userid" value=""/>
                    </div>
                    <div class="modal-footer" style="text-align: center;">
                        <button type="button" class="btn btn-primary"
                                onclick="request_password()">{{ trans('messages.confirm_password_yes') }}</button>
                        <button type="button" class="btn btn-default" id="close_modal"
                                data-dismiss="modal">{{ trans('messages.confirm_password_no') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{url('/js/clipboard.min.js')}}"></script>
        <script>
            jQuery(document).ready(function ($) {
                new Clipboard('.copy');

                $('#password_confirm').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget) // Button that triggered the modal
                    var recipient = button.data('userid') // Extract info from data-* attributes
                    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                    var modal = $(this)
                    modal.find('#change_password_userid').val(recipient)
                });
            });

            function request_password(user_id) {
                $.get('{{url('admin/changepassword')}}', {'id': $('#change_password_userid').val()}, function (data) {
                    $('#password').val(data);
                    $('#password_confirm').modal('hide');
                });
            }
        </script>
    @endpush
@endsection
