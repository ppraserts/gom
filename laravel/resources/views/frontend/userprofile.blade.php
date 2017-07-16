@extends('layouts.main')
@push('scripts')
<script src="//maps.google.com/maps/api/js?key=AIzaSyCTyLJemFK5wu_ONI1iZobLGK9pP1EVReo"></script>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datepicker({
            format: 'yyyy-mm-dd',
            language: 'th-th',
            autoclose: true,
            toggleActive: false,
            todayHighlight: false,
            todayBtn: false,
            startView: 2,
            maxViewMode: 2
        });

        $('#users_province').on('change', function (e) {
            console.log(e);
            var state_id = e.target.value;

            $.get('{{ url('information') }}/create/ajax-state?province_id=' + state_id, function (data) {
                console.log(data);
                var option = '';
                $('#users_city').empty();
                $('#users_district').empty();

                //option += '<option value="">{{ trans('validation.attributes.products_id') }}</option>';
                $.each(data, function (index, subCatObj) {
                    option += '<option value="' + subCatObj.AMPHUR_NAME + '">' + subCatObj.AMPHUR_NAME + '</option>';
                });
                $('#users_city').append(option);
                $("#users_city").val('{{ $item->users_city==""? old('users_city'):$item->users_city}}');
                $("#users_city").trigger("change");
            });
        });

        $('#users_city').on('change', function (e) {
            console.log(e);
            var state_id = e.target.value;

            $.get('{{ url('information') }}/create/ajax-state?city_id=' + state_id, function (data) {
                console.log(data);
                var option = '';
                $('#users_district').empty();

                //option += '<option value="">{{ trans('validation.attributes.products_id') }}</option>';
                $.each(data, function (index, subCatObj) {
                    option += '<option value="' + subCatObj.DISTRICT_NAME + '">' + subCatObj.DISTRICT_NAME + '</option>';
                });
                $('#users_district').append(option);
                $("#users_district").val('{{ $item->users_district==""? old('users_district'):$item->users_district}}');
            });
        });
        setTimeout(function () {
            var itemprovince = '{{ $item->users_province==""? old('users_province') : $item->users_province }}';
            if (itemprovince != "")
                $("#users_province").val('{{ $item->users_province==""? old('users_province') : $item->users_province }}').change();
        }, 500);
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
            $("[name=users_latitude]").val(this.getPosition().lat());
            $("[name=users_longitude]").val(this.getPosition().lng());
        });
    })
</script>
@endpush
@section('content')
    @include('shared.usermenu', array('setActive'=>'userprofiles'))
    <br/>
    <form enctype="multipart/form-data" role="form" method="POST"
          action="{{ url('user/updateprofiles') }}">
        {{ csrf_field() }}
        <div class="row">
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
            </div>
        </div>
        <div class="row">
            <div class="col-md-3" style="padding-right:30px;">

                <div class="form-group {{ $errors->has('iwantto') ? 'has-error' : '' }}"
                     style="background-color: #FFFFFF; padding: 15px;">

                    <strong>ต้องการ {{ $item->iwanttosale == 'sale' ? 'ขาย' : '' }} {{ $item->iwanttobuy == 'buy' ? 'ซื้อ' : ''}}</strong>
                </div>
                @if($item->users_imageprofile != "")
                    <img height="150" width="150" src="{{ url($item->users_imageprofile) }}" alt=""
                         class="img-circle">
                @endif
                <div class="form-group {{ $errors->has('users_imageprofile') ? 'has-error' : '' }}">
                    <strong>{{ trans('validation.attributes.users_imageprofile') }}:</strong>
                    <p style="color: #ff2222">{{trans('messages.image_file_size_limit')}} 500 KB</p>
                    {!! Form::file('users_imageprofile', null, array('placeholder' => trans('validation.attributes.users_imageprofile'),'class' => 'form-control')) !!}
                </div>

            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">แก้ไขโปรไฟล์</div>
                    <div class="panel-body">
                        @if($item->users_membertype == "personal")
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <strong>{{ trans('validation.attributes.users_idcard') }}</strong><br>
                                    <input class="form-control" type="text" value="{{ $item->users_idcard }}" readonly/>
                                </div>
                                @if($item->iwanttosale == 'sale')
                                    <div class="form-group col-md-6 {{ $errors->has('users_qrcode') ? 'has-error' : '' }}">
                                        <strong>{{ trans('validation.attributes.users_qrcode') }} :</strong>
                                        {!! Form::text('users_qrcode', $item->users_qrcode, array('placeholder' => trans('validation.attributes.users_qrcode'),'class' => 'form-control')) !!}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('users_firstname_th') ? 'has-error' : '' }}">
                                <strong>* {{ trans('validation.attributes.users_firstname_th') }} -
                                    {{ trans('validation.attributes.users_lastname_th') }}
                                    :</strong>
                                <div class="row">
                                    <div class="col-md-6">
                                        {!! Form::text('users_firstname_th', $item->users_firstname_th, array('placeholder' => trans('validation.attributes.users_firstname_th'),'class' => 'form-control')) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::text('users_lastname_th', $item->users_lastname_th, array('placeholder' => trans('validation.attributes.users_lastname_th'),'class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($item->users_membertype == "company")
                            <div class="row">
                                <div class="form-group col-md-6">
                                    {{ trans('validation.attributes.users_taxcode') }}
                                    :
                                    <strong>{{ $item->users_taxcode }}</strong>
                                </div>
                                @if($item->iwanttosale == 'sale')
                                    <div class="form-group col-md-6 {{ $errors->has('users_qrcode') ? 'has-error' : '' }}">
                                        <strong>{{ trans('validation.attributes.users_qrcode') }}
                                            :</strong>
                                        {!! Form::text('users_qrcode', $item->users_qrcode, array('placeholder' => trans('validation.attributes.users_qrcode'),'class' => 'form-control')) !!}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('users_company_th') ? 'has-error' : '' }}">
                                <strong>{{ trans('validation.attributes.users_company_th') }}
                                    :</strong>
                                {!! Form::text('users_company_th', $item->users_company_th, array('placeholder' => trans('validation.attributes.users_company_th'),'class' => 'form-control')) !!}
                            </div>
                            {{--<div class="form-group {{ $errors->has('users_company_en') ? 'has-error' : '' }}">
                                <strong>{{ trans('validation.attributes.users_company_en') }}
                                    :</strong>
                                {!! Form::text('users_company_en', $item->users_company_en, array('placeholder' => trans('validation.attributes.users_company_en'),'class' => 'form-control')) !!}
                            </div>--}}
                        @endif
                        <div class="row">
                            <div class="form-group col-md-12">
                                <input type="checkbox" name="requset_email_system" value="1"
                                       @if(!empty($item->requset_email_system)) checked @endif>
                                {{ trans('messages.lable_requset_email_system') }}
                            </div>
                        </div>
                        @if($item->iwanttosale == 'sale')
                            @if(isset($standards))
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <strong>{{ trans('validation.attributes.guarantee') }} :</strong>
                                        @for($i = 0 ; $i < count($standards) ; $i++)
                                            <label class="checkbox-inline">
                                                <input name="users_standard[]" type="checkbox" disabled
                                                       value="{{ $standards[$i]->id}}" {{ $standards[$i]->checked ? "checked" : ""}}>
                                                {{$standards[$i]->name}}
                                            </label>
                                        @endfor
                                    </div>
                                </div>
                            @endif
                            @if(isset($markets))
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <strong>{{ trans('validation.attributes.market') }} :</strong>
                                        @for($i = 0 ; $i < count($markets) ; $i++)
                                            <label class="checkbox-inline">
                                                <input name="users_standard[]" type="checkbox" disabled
                                                       value="{{ $markets[$i]->id}}" {{ $markets[$i]->checked ? "checked" : ""}}>
                                                {{$markets[$i]->market_title_th}}
                                            </label>
                                        @endfor
                                    </div>
                                </div>
                            @endif
                        @endif


                        <div class="row">
                            <div class="form-group col-md-6 {{ $errors->has('email') ? 'has-error' : '' }}">
                                <strong>* {{ trans('validation.attributes.email') }} :</strong>
                                <input id="email" type="email" class="form-control" name="email"
                                       value="{{ $item->email }}" @if(!empty($item->email)) disabled @endif>
                            </div>

                            <div class="form-group col-md-6 {{ $errors->has('users_mobilephone') ? 'has-error' : '' }}">
                                <strong>* {{ trans('validation.attributes.users_mobilephone') }}
                                    :</strong>
                                {!! Form::text('users_mobilephone', $item->users_mobilephone, array('placeholder' => trans('validation.attributes.users_mobilephone'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 {{ $errors->has('users_addressname') ? 'has-error' : '' }}">
                                <strong>{{ trans('validation.attributes.users_addressname') }}
                                    :</strong>
                                {!! Form::text('users_addressname', $item->users_addressname, array('placeholder' => trans('validation.attributes.users_addressname'),'class' => 'form-control')) !!}
                            </div>
                        </div>
                        {{--<div class="form-group {{ $errors->has('users_street') ? 'has-error' : '' }}">
                            <strong>{{ trans('validation.attributes.users_street') }}
                                :</strong>
                            {!! Form::text('users_street', $item->users_street, array('placeholder' => trans('validation.attributes.users_street'),'class' => 'form-control')) !!}
                        </div>--}}

                        <div class="row">
                            <div class="form-group col-md-6 {{ $errors->has('users_province') ? 'has-error' : '' }}">
                                <strong>{{ trans('validation.attributes.users_province') }}
                                    :</strong>
                                <select id="users_province" name="users_province" class="form-control">
                                    <option value="">{{ trans('messages.allprovince') }}</option>
                                    @foreach ($provinceItem as $key => $province)
                                        @if($item->users_province == $province->PROVINCE_NAME)
                                            <option selected
                                                    value="{{ $province->PROVINCE_NAME }}">{{ $province->PROVINCE_NAME }}</option>
                                        @else
                                            <option value="{{ $province->PROVINCE_NAME }}">{{ $province->PROVINCE_NAME }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 {{ $errors->has('users_city') ? 'has-error' : '' }}">
                                <strong>{{ trans('validation.attributes.users_city') }}
                                    :</strong>
                                <select id="users_city" name="users_city" class="form-control">
                                </select>
                            </div>
                            <div class="form-group col-md-6 {{ $errors->has('users_district') ? 'has-error' : '' }}">
                                <strong>{{ trans('validation.attributes.users_district') }}
                                    :</strong>
                                <select id="users_district" name="users_district" class="form-control">
                                </select>
                            </div>
                            <div class="form-group col-md-6 {{ $errors->has('users_postcode') ? 'has-error' : '' }}">
                                <strong>{{ trans('validation.attributes.users_postcode') }}
                                    :</strong>
                                {!! Form::text('users_postcode', $item->users_postcode, array('placeholder' => trans('validation.attributes.users_postcode'),'class' => 'form-control')) !!}
                            </div>

                        </div>

                        {{--<div class="form-group {{ $errors->has('users_phone') ? 'has-error' : '' }}">
                            <strong>{{ trans('validation.attributes.users_phone') }}
                                :</strong>
                            {!! Form::text('users_phone', $item->users_phone, array('placeholder' => trans('validation.attributes.users_phone'),'class' => 'form-control')) !!}
                        </div>--}}
                        {{--@if($item->users_membertype == "company")
                            <div class="form-group {{ $errors->has('users_fax') ? 'has-error' : '' }}">
                                <strong>{{ trans('validation.attributes.users_fax') }}
                                    :</strong>
                                {!! Form::text('users_fax', $item->users_fax, array('placeholder' => trans('validation.attributes.users_fax'),'class' => 'form-control')) !!}
                            </div>
                        @endif--}}

                        <div class="row">
                            <div class="form-group col-md-6">
                                <strong>{{ trans('validation.attributes.users_latitude') }} :</strong>
                                {!! Form::text('users_latitude', $item->users_latitude, array('placeholder' => trans('validation.attributes.users_latitude'),'style' => 'text-align:center;','class' => 'form-control')) !!}

                            </div>
                            <div class="col-md-6">
                                <strong>{{ trans('validation.attributes.users_longitude') }} :</strong>
                                {!! Form::text('users_longitude', $item->users_longitude, array('placeholder' => trans('validation.attributes.users_longitude'),'style' => 'text-align:center;','class' => 'form-control')) !!}

                            </div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="text-center">
                        {{ Form::hidden('users_imageprofile_temp', $item->users_imageprofile) }}
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                            {{ trans('messages.button_save')}}</button>

                    </div>
                </div>
            </div>
            {{--<div class="form-group {{ $errors->has('users_longitude') ? 'has-error' : '' }}">
                <strong>{{ trans('validation.attributes.users_latitude'). " - " .trans('validation.attributes.users_longitude') }}
                    :</strong>
                <div class="row">
                    <div class="col-md-6">
                        {!! Form::text('users_latitude', $item->users_latitude, array('placeholder' => trans('validation.attributes.users_latitude'),'style' => 'text-align:center;','class' => 'form-control')) !!}

                    </div>
                    <div class="col-md-6">
                        {!! Form::text('users_longitude', $item->users_longitude, array('placeholder' => trans('validation.attributes.users_longitude'),'style' => 'text-align:center;','class' => 'form-control')) !!}

                    </div>
                </div>
            </div>--}}
            {{--<div class="form-group" style="margin-top:10px; margin-bottom:20px; display:none;">
                <div id="map" style="width: 100%; height: 300px;"></div>
            </div>--}}

        </div>
    </form>
@stop
