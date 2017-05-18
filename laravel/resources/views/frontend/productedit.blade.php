<?php
use App\ProductCategory;

$productcategories = ProductCategory::pluck('productcategory_title_th', 'id');
$pagetitle = trans('messages.menu_add_product');

if ($mode == "create") {
    $method = "POST";
    $formModelId = 0;
    $controllerAction = "userproduct.store";
} else {
    $method = "PATCH";
    $formModelId = $item->id;
    $controllerAction = "userproduct.update";
}
?>
@extends('layouts.main')
@section('content')
    @include('shared.usermenu', array('setActive'=>'addproduct'))
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
        {!! Form::model($item, ['method' => $method,'route' => [$controllerAction, $formModelId]]) !!}

        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group {{ $errors->has('product_cate') ? 'has-error' : '' }}">
                    <strong>* {{ Lang::get('validation.attributes.productcategorys_id') }}:</strong>
                    {!! Form::select('productcategory_id', $productcategories, null, array('class'=>'form-control ','style'=>'' )) !!}
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group {{ $errors->has('product_name_th') ? 'has-error' : '' }}">
                    <strong>* {{ Lang::get('validation.attributes.product_name_th') }}:</strong>
                    {!! Form::text('product_name_th', null, array('placeholder' => Lang::get('validation.attributes.product_name_th'),'class' => 'form-control')) !!}
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group {{ $errors->has('product_name_en') ? 'has-error' : '' }}">
                    <strong>* {{ Lang::get('validation.attributes.product_name_en') }}:</strong>
                    {!! Form::text('product_name_en', null, array('placeholder' => Lang::get('validation.attributes.product_name_en'),'class' => 'form-control')) !!}
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group {{ $errors->has('sequence') ? 'has-error' : '' }}">
                    <label class="col-sm-2 control-label" style="padding-left: 0px;">
                        <strong>{{ Lang::get('validation.attributes.sequence') }}:</strong>
                    </label>
                    <div class="col-sm-2" style="padding-left: 0px;">
                        {!! Form::number('sequence', null, array('placeholder' => Lang::get('validation.attributes.sequence'),'style' => 'text-align:center;','class' => 'form-control')) !!}
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>" />
                <button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                    {{ trans('messages.button_save')}}</button>
            </div>

        </div>
        {!! Form::close() !!}
    </div>
@endsection
