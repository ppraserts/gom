<?php
use App\ProductCategory;

$pagetitle = trans('messages.menu_add_product');

if ($mode == "create") {
    $method = "POST";
    $formModelId = 0;
    $controllerAction = "promotion.store";
} else {
    $method = "PATCH";
    $formModelId = $item->id;
    $controllerAction = "promotion.update";
}
?>
@extends('layouts.main')
@push('scripts')
<script src="//maps.google.com/maps/api/js?key=AIzaSyCTyLJemFK5wu_ONI1iZobLGK9pP1EVReo"></script>
<script type="text/javascript">
    $(function () {
        $('#pick_start_date').datepicker({
            format: 'yyyy-mm-dd',
            language: 'th-th',
            autoclose: true,
            toggleActive: false,
            todayHighlight: false,
            todayBtn: false,
            startView: 2,
            maxViewMode: 2
        });
        $('#pick_end_date').datepicker({
            format: 'yyyy-mm-dd',
            language: 'th-th',
            autoclose: true,
            toggleActive: false,
            todayHighlight: false,
            todayBtn: false,
            startView: 2,
            maxViewMode: 2
        });
    })
</script>
@endpush
@section('content')
    @include('shared.usermenu', array('setActive'=>'promotion'))
    <div class="col-sm-12">
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
        {!! Form::model($item, ['method' => $method,'route' => [$controllerAction, $formModelId] ,'files' => true]) !!}

        <div class="row">
            @if($method === "PATCH")
                <div class="col-xs-12 col-sm-12 col-md-12" style="margin-bottom: 15px">
                    <strong>{{ trans('messages.link') }} : </strong><a
                            href="{{ url ($shop->shop_name."/promotion/".$item->id) }}"> {{ url ($shop->shop_name."/promotion/".$item->id) }}</a>
                </div>
            @endif

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group {{ $errors->has('promotion_title') ? 'has-error' : '' }}">
                    <strong>* {{ trans('validation.attributes.promotion_title') }}:</strong>
                    {!! Form::text('promotion_title', null, array('placeholder' => trans('validation.attributes.promotion_title'),'class' => 'form-control')) !!}
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group {{ $errors->has('promotion_description') ? 'has-error' : '' }}">
                    <strong>* {{ trans('validation.attributes.promotion_description') }}:</strong>

                    {!! Form::textarea('promotion_description', null, array('placeholder' => trans('validation.attributes.promotion_description'),'class' => 'form-control')) !!}

                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group {{ $errors->has('image_file') ? 'has-error' : '' }}">
                    <strong>* {{ trans('validation.attributes.promotion_image') }}:</strong>
                    <p style="color: #ff2222">{{trans('messages.image_size')}} 745 x 92 pixel และ {{trans('messages.image_file_size_limit')}} 500 KB</p>
                    {!! Form::file('image_file', null, array('placeholder' => trans('validation.attributes.promotion_image'),'class' => 'form-control')) !!}

                    @if(isset($item->image_file))
                        <img img_promotion width="400px" height="300px" class="img-promotion img-responsive" src="{{ url($item->image_file) }}" />
                    @else
                        <img img_promotion width="400px" height="300px" class="img-promotion img-responsive" />
                    @endif
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group {{ $errors->has('start_date') ? 'has-error' : '' }}">
                    <strong>* {{ trans('validation.attributes.promotion_start_date') }}:</strong>
                    <div class='input-group date' id='pick_start_date'>
                        {!! Form::text('start_date', DateFuncs::thai_date($item->start_date), array('placeholder' => trans('validation.attributes.promotion_start_date'),'class' => 'form-control')) !!}
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group {{ $errors->has('end_date') ? 'has-error' : '' }}">
                    <strong>* {{ trans('validation.attributes.promotion_end_date') }}:</strong>
                    <div class='input-group date' id='pick_end_date'>
                        {!! Form::text('end_date', DateFuncs::thai_date($item->end_date), array('placeholder' => trans('validation.attributes.promotion_end_date'),'class' => 'form-control')) !!}
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group {{ $errors->has('sequence') ? 'has-error' : '' }}">
                    <label class="col-sm-2 control-label" style="padding-left: 0px;">
                        <strong>{{ trans('validation.attributes.sequence') }}:</strong>
                    </label>
                    <div class="col-sm-2" style="padding-left: 0px;">
                        {!! Form::number('sequence', null, array('placeholder' => trans('validation.attributes.sequence'),'style' => 'text-align:center;','class' => 'form-control')) !!}
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>"/>
                <input type="hidden" id="shop_id" name="shop_id" value="<?php echo $shop_id; ?>"/>
                <button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                    {{ trans('messages.button_save')}}</button>
            </div>

        </div>
        {!! Form::close() !!}
    </div>
@endsection

{{--
@push('script')
        <script>

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#img_promotion')
                            .attr('src', e.target.result)
                            .width(400)
                            .height(300);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }

        </script>
@endpush--}}
