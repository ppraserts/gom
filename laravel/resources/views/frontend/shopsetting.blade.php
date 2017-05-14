@extends('layouts.main')
@section('content')
    @include('shared.usermenu', array('setActive'=>'shopsetting'))
    <BR>
    <div class="col-sm-12">
        @if (count($errors) > 0)
            <div class="row">
                <div class="alert alert-danger">
                    <strong>{{ trans('messages.message_whoops_error')}}</strong> {{ trans('messages.message_result_error')}}
                    <br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @if ($message = Session::get('success'))
            <div class="row">
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            </div>
        @endif

        <div class="row">
            {{--Shop Setting Form--}}
            {!! Form::open(array('route'=> 'shopsetting.store' ,'files' => true , 'method'=> 'POST')) !!}
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
                <div class="col-md-5 col-sm-5">
                    <div class="form-group {{ $errors->has('shop_name') ? 'has-error' : '' }}">
                        <strong>* {{ trans('validation.attributes.shop_name') }}</strong> <span style="color: #ff2222;"> *{{trans('messages.english_only')}}
                            *{{trans('messages.cant_change_url')}}</span>
                        @if($shop->id > 0 && isset($shop->shop_name))
                            {!! Form::text('shop_name', isset($shop->shop_name)?$shop->shop_name:"", array('placeholder' => trans('validation.attributes.shop_name'),'class' => 'form-control' , 'id' => 'shop_name', 'readonly')) !!}
                            <div style="padding-top: 10px;"><strong>URL : </strong><a
                                        href="{{ url($shop->shop_name) }}" target="_blank">{{URL::to('/')}}/<span
                                            id="uri">{{isset($shop->shop_name)?$shop->shop_name:""}}</span></a></div>
                        @else
                            {!! Form::text('shop_name', isset($shop->shop_name)?$shop->shop_name:"", array('placeholder' => trans('validation.attributes.shop_name'),'class' => 'form-control' , 'id' => 'shop_name')) !!}
                            {{URL::to('/')}}/<span id="uri"
                                                   style="margin-bottom: 10px;">{{isset($shop->shop_name)?$shop->shop_name:""}}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-7 col-sm-7">
                    <div class="form-group {{ $errors->has('shop_title') ? 'has-error' : '' }}">
                        <strong>* {{ trans('validation.attributes.shop_title') }}:</strong> <i
                                class="fa fa-question-circle" aria-hidden="true" data-toggle="modal"
                                data-target="#modal_help"></i>
                        {!! Form::text('shop_title', isset($shop->shop_title)?$shop->shop_title:"", array('placeholder' => trans('validation.attributes.shop_title'),'class' => 'form-control' )) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">

                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong> {{ trans('validation.attributes.shop_subtitle') }}: </strong><i
                                class="fa fa-question-circle" aria-hidden="true" data-toggle="modal"
                                data-target="#modal_help"></i>
                        {!! Form::text('shop_subtitle',isset($shop->shop_subtitle)?$shop->shop_subtitle:"" , array('placeholder' => trans('validation.attributes.shop_subtitle'),'class' => 'form-control' )) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong> {{ trans('validation.attributes.shop_description') }}: </strong><i
                                class="fa fa-question-circle" aria-hidden="true" data-toggle="modal"
                                data-target="#modal_help"></i>
                        {!! Form::textarea('shop_description', isset($shop->shop_description)?$shop->shop_description:"", array('placeholder' => trans('validation.attributes.shop_description'),'class' => 'form-control','style'=>'height:100px')) !!}
                    </div>
                </div>
            </div>
            {{--Shop Theme--}}
            @if($shop!= null)
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>{{ trans('messages.shop_theme')}}</strong></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div style="min-height: 28px; margin-left: 10px; position: relative">
                                    @if($shop->theme=="theme3")
                                        <i class="fa fa-2x fa-check-square-o"
                                           style="color:#00cc66; margin-right: 8px;"></i>
                                    @endif
                                    <strong style="position: absolute; top: 5px;">{{ trans('messages.shop_theme') }}
                                        1</strong>
                                </div>
                                <div class="hover ehover1 classWithPad">
                                    <img class="img-responsive" src="{{ asset('/images/small_theme3.png') }}" alt="">
                                    <div class="overlay">
                                        <h2>รูปแบบที่ 1</h2>
                                        <button class="info" data-toggle="modal" type="button"
                                                data-target="#modal1">{{ trans('messages.preview')}}</button>
                                        <a href="{{ url('user/settheme' , 'theme3' ) }}"
                                           class="info">{{ trans('messages.apply')}}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div style="min-height: 28px; margin-left: 10px; position: relative">
                                    @if($shop->theme=="theme1")
                                        <i class="fa fa-2x fa-check-square-o"
                                           style="color:#00cc66; margin-right: 8px;"></i>
                                    @endif
                                    <strong style="position: absolute; top: 5px;">{{ trans('messages.shop_theme') }}
                                        2</strong>
                                </div>
                                <div class="hover ehover1 classWithPad">
                                    <img class="img-responsive" src="{{ asset('/images/small_theme1.png') }}" alt="">
                                    <div class="overlay">
                                        <h2>รูปแบบที่ 2</h2>
                                        <button class="info" data-toggle="modal" type="button"
                                                data-target="#modal2">{{ trans('messages.preview')}}</button>
                                        <a href="{{ url('user/settheme' , 'theme1'  ) }}"
                                           class="info">{{ trans('messages.apply')}}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div style="min-height: 28px; margin-left: 10px; position: relative">
                                    @if($shop->theme=="theme2")
                                        <i class="fa fa-2x fa-check-square-o"
                                           style="color:#00cc66; margin-right: 8px;"></i>
                                    @endif
                                    <strong style="position: absolute;top: 5px;">{{ trans('messages.shop_theme') }}
                                        3</strong>
                                </div>
                                <div class="hover ehover1 classWithPad">
                                    <img class="img-responsive" src="{{ asset('/images/small_theme2.png') }}" alt="">
                                    <div class="overlay">
                                        <h2>รูปแบบที่ 3</h2>
                                        <button class="info" data-toggle="modal" type="button"
                                                data-target="#modal3">{{ trans('messages.preview')}}</button>
                                        <a href="{{ url('user/settheme' , 'theme2' ) }}"
                                           class="info">{{ trans('messages.apply')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group" style="padding-left: 10px;">
                                    <strong> {{ trans('messages.select_text_color') }}: </strong><br>
                                    <div class="btn-group" data-toggle="buttons" style="padding-top: 5px">
                                        <label class="btn btn-default {{ ($shop->text_color =="" || $shop->text_color =='#000000') =='#000000' ? 'active' : '' }}">
                                            {{ Form::radio('text_color', '#000000', ($shop->text_color =="" || $shop->text_color =='#000000'),['autocomplete' => 'off']) }}
                                            {{trans('messages.color_black')}}
                                        </label>
                                        <label class="btn btn-default {{ $shop->text_color =='#cccccc' ? 'active' : '' }}">
                                            {{ Form::radio('text_color', '#cccccc', $shop->text_color =='#cccccc',['autocomplete' => 'off']) }}
                                            {{trans('messages.color_gray')}}
                                        </label>
                                        <label class="btn btn-default {{ $shop->text_color =='#ffffff' ? 'active' : '' }}">
                                            {{ Form::radio('text_color', '#ffffff', $shop->text_color =='#ffffff',['autocomplete' => 'off']) }}
                                            {{trans('messages.color_white')}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{--Shop Slide--}}
            <div class="panel panel-default">
                <div class="panel-heading"><strong>{{ trans('messages.shop_image')}}</strong></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group row">
                                            <strong>{{ trans('validation.attributes.shop_theme_image') }} 1
                                                :</strong><br>
                                            <div class="btn-group" data-toggle="buttons"
                                                 style="padding-top: 5px; padding-bottom: 10px;">
                                                <label class="btn btn-default {{ $shop->image_file_3 ==""  ? 'active' : '' }}">
                                                    {{ Form::radio('image_file_3_type', '0',  $shop->image_file_3 ==""  ? 'active' : '' ,['autocomplete' => 'off']) }}
                                                    {{ trans('messages.use_theme_image') }}
                                                </label>
                                                <label class="btn btn-default {{ $shop->image_file_3 !="" ? 'active' : '' }}">
                                                    {{ Form::radio('image_file_3_type', '1', $shop->image_file_3 !="" ,['autocomplete' => 'off']) }}
                                                    {{ trans('messages.choose_image') }}
                                                </label>
                                            </div>
                                            <div id="image_file_3_form">
                                                {!! Form::file('image_file_3', null, array('class' => 'filestyle')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="theme-header-image">
                                        @if($shop->image_file_3 != '')
                                            <img id="img_theme3" class="img-thumbnail" width="304" height="236"
                                                 src="{{ asset($shop->image_file_3) }}" class="img-responsive"
                                                 alt="a">
                                        @else
                                            <img id="img_theme3" class="img-thumbnail" width="304" height="236"
                                                 src="{{asset('/assets/theme/images/header-3.jpg')}}"
                                                 class="img-responsive"
                                                 alt="a">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group row">
                                            <strong>{{ trans('validation.attributes.shop_theme_image') }}
                                                2:</strong><br>
                                            <div class="btn-group" data-toggle="buttons"
                                                 style="padding-top: 5px; padding-bottom: 10px;">
                                                <label class="btn btn-default {{ $shop->image_file_1 ==""  ? 'active' : '' }}">
                                                    {{ Form::radio('image_file_1_type', '0',  $shop->image_file_1 ==""  ? 'active' : '' ,['autocomplete' => 'off']) }}
                                                    {{ trans('messages.use_theme_image') }}
                                                </label>
                                                <label class="btn btn-default {{ $shop->image_file_1 !="" ? 'active' : '' }}">
                                                    {{ Form::radio('image_file_1_type', '1', $shop->image_file_1 !="" ,['autocomplete' => 'off']) }}
                                                    {{ trans('messages.choose_image') }}
                                                </label>
                                            </div>
                                            <div id="image_file_1_form">
                                            {!! Form::file('image_file_1', null, array('class' => 'filestyle')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        @if($shop->image_file_1 != '')
                                            <img id="img_theme1" class="img-thumbnail" width="304" height="236"
                                                 src="{{ asset($shop->image_file_1) }}" class="img-responsive"
                                                 alt="a">
                                        @else
                                            <img id="img_theme1" class="img-thumbnail" width="304" height="236"
                                                 src="{{asset('/assets/theme/images/header-1.jpg')}}"
                                                 class="img-responsive"
                                                 alt="a">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group row">
                                            <strong>{{ trans('validation.attributes.shop_theme_image') }} 3:</strong><br>
                                            <div class="btn-group" data-toggle="buttons"
                                                 style="padding-top: 5px; padding-bottom: 10px;">
                                                <label class="btn btn-default {{ $shop->image_file_2 ==""  ? 'active' : '' }}">
                                                    {{ Form::radio('image_file_2_type', '0',  $shop->image_file_2 ==""  ? 'active' : '' ,['autocomplete' => 'off']) }}
                                                    {{ trans('messages.use_theme_image') }}
                                                </label>
                                                <label class="btn btn-default {{ $shop->image_file_2 !="" ? 'active' : '' }}">
                                                    {{ Form::radio('image_file_2_type', '1', $shop->image_file_2 !="" ,['autocomplete' => 'off']) }}
                                                    {{ trans('messages.choose_image') }}
                                                </label>
                                            </div>
                                            <div id="image_file_2_form">
                                                {!! Form::file('image_file_2', null, array('class' => 'filestyle')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        @if($shop->image_file_2 != '')
                                            <img id="img_theme2" class="img-thumbnail" width="304" height="236"
                                                 src="{{ asset($shop->image_file_2) }}" class="img-responsive"
                                                 alt="a">
                                        @else
                                            <img id="img_theme2" class="img-thumbnail" width="304" height="236"
                                                 src="{{asset('/assets/theme/images/header-2.jpg')}}"
                                                 class="img-responsive"
                                                 alt="a">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
        <BR>
        {{--Shop Theme--}}
        @if($shop!= null)
            {{--<div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>{{ trans('messages.shop_theme')}}</strong></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <strong>{{ trans('messages.shop_theme') }} 1</strong>
                                <div class="hover ehover1 classWithPad">
                                    <img class="img-responsive" src="{{ asset('/images/small_theme3.png') }}" alt="">
                                    <div class="overlay">
                                        <h2>รูปแบบที่ 1</h2>
                                        <button class="info" data-toggle="modal"
                                                data-target="#modal1">{{ trans('messages.preview')}}</button>
                                        <a href="{{ url('user/settheme' , 'theme3' ) }}"
                                           class="info">{{ trans('messages.apply')}}</a>
                                    </div>
                                </div>
                                @if($shop->theme=="theme3")
                                    <div class="text-center"><i class="fa fa-2x fa-check-square-o"
                                                                style="color:#00cc66"></i></div>
                                @endif
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <strong>{{ trans('messages.shop_theme') }} 2</strong>
                                <div class="hover ehover1 classWithPad">
                                    <img class="img-responsive" src="{{ asset('/images/small_theme1.png') }}" alt="">
                                    <div class="overlay">
                                        <h2>รูปแบบที่ 2</h2>
                                        <button class="info" data-toggle="modal"
                                                data-target="#modal2">{{ trans('messages.preview')}}</button>
                                        <a href="{{ url('user/settheme' , 'theme1'  ) }}"
                                           class="info">{{ trans('messages.apply')}}</a>
                                    </div>
                                </div>
                                @if($shop->theme=="theme1")
                                    <div class="text-center"><i class="fa fa-2x fa-check-square-o"
                                                                style="color:#00cc66"></i></div>
                                @endif
                            </div>


                            <div class="col-md-4 col-sm-6 col-xs-12">

                                @if($shop->theme=="theme2")
                                    <i class="fa fa-2x fa-check-square-o" style="color:#00cc66"></i>
                                @endif
                                <strong>{{ trans('messages.shop_theme') }} 3</strong>
                                <div class="hover ehover1 classWithPad">
                                    <img class="img-responsive" src="{{ asset('/images/small_theme2.png') }}" alt="">
                                    <div class="overlay">
                                        <h2>รูปแบบที่ 3</h2>
                                        <button class="info" data-toggle="modal"
                                                data-target="#modal3">{{ trans('messages.preview')}}</button>
                                        <a href="{{ url('user/settheme' , 'theme2' ) }}"
                                           class="info">{{ trans('messages.apply')}}</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>--}}
        <!-- modals; the pop up boxes that contain the code for the effects -->
            <div id="modal1" class="modal fade" tabindex="-1" role="dialog" data-keyboard="false"
                 data-backdrop="static">
                <div class="vertical-alignment-helper">
                    <div class="modal-dialog modal-lg vertical-align-center">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title text-primary">รูปแบบที่ 1</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <img class="img-responsive" src="{{asset('/images/theme3.png')}}" alt="">
                                        <BR>
                                        <p>รายละเอียดเกี่ยวกับธีม</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="{{ url('user/settheme' , 'theme3' ) }}" type="button"
                                   class="btn btn-primary">{{ trans('messages.apply')}}</a>
                                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->

            <div id="modal2" class="modal fade" tabindex="-1" role="dialog" data-keyboard="false"
                 data-backdrop="static">
                <div class="vertical-alignment-helper">
                    <div class="modal-dialog modal-lg vertical-align-center">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">รูปแบบที่ 2</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <img class="img-responsive" src="{{ asset('/images/theme1.png') }}" alt="">
                                        <BR>
                                        <p>รายละเอียดเกี่ยวกับธีม</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="{{ url('user/settheme' , 'theme1' ) }}" type="button"
                                   class="btn btn-primary">{{ trans('messages.apply')}}</a>
                                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div>
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <div id="modal3" class="modal fade" tabindex="-1" role="dialog" data-keyboard="false"
                 data-backdrop="static">
                <div class="vertical-alignment-helper">
                    <div class="modal-dialog modal-lg vertical-align-center">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">รูปแบบที่ 3</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <img class="img-responsive" src="{{asset('/images/theme2.png')}}" alt="">
                                        <BR>
                                        <p>รายละเอียดเกี่ยวกับธีม</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="{{ url('user/settheme' , 'theme2' ) }}" type="button"
                                   class="btn btn-primary">{{ trans('messages.apply')}}</a>
                                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
            </div><!-- /.modal -->

            <div id="modal_help" class="modal fade" tabindex="-1" role="dialog" data-keyboard="false"
                 data-backdrop="static">
                <div class="vertical-alignment-helper">
                    <div class="modal-dialog modal-lg vertical-align-center">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <img src="{{asset('/images/theme_help.png')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                            </div>
                        </div><!-- /.modal-content -->

                    </div><!-- /.modal-dialog -->
                </div>
            </div><!-- /.modal -->
        @endif
        @stop

        @push('scripts')
        <script>
            $(document).ready(function () {

                hideSuccessMessage();

                setupFileStyle();

                setupFillURI();

                checkImageSource();

            });

            function setupFileStyle() {
                $(":file").filestyle({buttonText: " Choose", size: 'sm', icon: false});
            }

            function hideSuccessMessage() {
                setTimeout(function () {
                    $('.alert-success').hide();
                }, 2000);

            }

            function setupFillURI() {
                $("#shop_name").on("change paste keyup", function () {
                    $("#uri").html($(this).val());
                });
            }

            function checkImageSource() {

                $('input[type=radio][name=image_file_3_type]').change(function () {
                    if (this.value == '0') {
                        $("#image_file_3_form").hide();
                        $("#img_theme3").attr('src', '{{ asset('/assets/theme/images/header-3.jpg') }}');
                    }
                    else if (this.value == '1') {
                        $("#image_file_3_form").show();
                        @if($shop->image_file_3 != '')
                        $("#img_theme3").attr('src', '{{ asset($shop->image_file_3) }}');
                        @endif
                    }
                });

                $('input[type=radio][name=image_file_1_type]').change(function () {
                    if (this.value == '0') {
                        $("#image_file_1_form").hide();
                        $("#img_theme1").attr('src', '{{ asset('/assets/theme/images/header-1.jpg') }}');
                    }
                    else if (this.value == '1') {
                        $("#image_file_1_form").show();
                        @if($shop->image_file_1 != '')
                        $("#img_theme1").attr('src', '{{ asset($shop->image_file_1) }}');
                        @endif
                    }
                });

                $('input[type=radio][name=image_file_2_type]').change(function () {
                    if (this.value == '0') {
                        $("#image_file_2_form").hide();
                        $("#img_theme2").attr('src', '{{ asset('/assets/theme/images/header-2.jpg') }}');
                    }
                    else if (this.value == '1') {
                        $("#image_file_2_form").show();
                        @if($shop->image_file_2 != '')
                        $("#img_theme2").attr('src', '{{ asset($shop->image_file_2) }}');
                        @endif
                    }
                });

                @if($shop->image_file_1 == '')
                        $("#image_file_1_form").hide();
                @endif

                @if($shop->image_file_2 == '')
                        $("#image_file_2_form").hide();
                @endif

                @if($shop->image_file_3 == '')
                        $("#image_file_3_form").hide();
                @endif
            }

        </script>
    @endpush