<?php
use App\FaqCategory;
$faqcategoryItem = FaqCategory::find($_REQUEST["faqcategory"]);
$pagetitle = trans('messages.menu_faq')." ($faqcategoryItem->faqcategory_title_th)";

if($mode=="create")
{
  $method = "POST";
  $formModelId = 0;
  $controllerAction = "faq.store";
}
else
{
  $method = "PATCH";
  $formModelId =  $item->id;
  $controllerAction = "faq.update";
}
?>
@extends('layouts.dashboard')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="glyphicon glyphicon-question-sign"></i>')
@section('section')
<div class="col-sm-12">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h3>{{ trans('messages.addeditform') }}</h3>
            </div>
            <div class="pull-right">
                <a class="btn btn-default" href="{{ route('faq.index') }}?faqcategory=<?php echo $_REQUEST["faqcategory"]; ?>">
                  <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                   {{ trans('messages.button_back') }}</a>
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

    {!! Form::model($item, ['method' => $method,'route' => [$controllerAction, $formModelId]]) !!}

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('faq_question_th') ? 'has-error' : '' }}">
                <strong>* {{ Lang::get('validation.attributes.faq_question_th') }}:</strong>
                {!! Form::text('faq_question_th', null, array('placeholder' => Lang::get('validation.attributes.faq_question_th'),'class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('faq_answer_th') ? 'has-error' : '' }}">
                <strong>* {{ Lang::get('validation.attributes.faq_answer_th') }}:</strong>
                {!! Form::textarea('faq_answer_th', null, array('placeholder' => Lang::get('validation.attributes.faq_answer_th'),'class' => 'form-control','style'=>'height:100px')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('faq_question_en') ? 'has-error' : '' }}">
                <strong>* {{ Lang::get('validation.attributes.faq_question_en') }}:</strong>
                {!! Form::text('faq_question_en', null, array('placeholder' => Lang::get('validation.attributes.faq_question_en'),'class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('faq_answer_en') ? 'has-error' : '' }}">
                <strong>* {{ Lang::get('validation.attributes.faq_answer_en') }}:</strong>
                {!! Form::textarea('faq_answer_en', null, array('placeholder' => Lang::get('validation.attributes.faq_answer_en'),'class' => 'form-control','style'=>'height:100px')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group {{ $errors->has('sequence') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label" style="padding-left: 0px;">
                  <strong>* {{ Lang::get('validation.attributes.sequence') }}:</strong>
                </label>
                <div class="col-sm-2" style="padding-left: 0px;">
                {!! Form::number('sequence', null, array('placeholder' => Lang::get('validation.attributes.sequence'),'style' => 'text-align:center;','class' => 'form-control')) !!}
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12" >
               <input type="hidden" id="faqcategory_id" name="faqcategory_id" value="<?php echo $_REQUEST["faqcategory"]; ?>" />
                <button type="submit" class="btn btn-primary">
                  <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                  {{ trans('messages.button_save')}}</button>
        </div>

    </div>
    {!! Form::close() !!}
</div>
@endsection
