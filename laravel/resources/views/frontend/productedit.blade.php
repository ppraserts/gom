<?php
  if($useritem->iwantto == "sale")
      $activemenu = "iwanttosale";
  else
      $activemenu = "iwanttobuy";
?>
@extends('layouts.main')
@push('scripts')
<script src="{{ asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
<script>
  CKEDITOR.replace( 'product_description' );
  $('#productcategorys_id').on('change', function(e){
      console.log(e);
      var state_id = e.target.value;

      $.get('{{ url('information') }}/create/ajax-state?productcategorys_id=' + state_id, function(data) {
          console.log(data);
          var option = '';
          $('#products_id').empty();

          //option += '<option value="">{{ Lang::get('validation.attributes.products_id') }}</option>';
          $.each(data, function(index,subCatObj){
            option += '<option value="'+ subCatObj.id + '">' + subCatObj.product_name_{{ Lang::locale() }} + '</option>';
          });
          $('#products_id').append(option);
          $( "#products_id" ).val({{ $item->id==0? old('products_id') : $item->products_id }});
      });
  });
  $('#btnDelete').on('click', function(e){
      if(confirm('{{ trans('messages.confirm_delete', ['attribute' => $item->product_title]) }}'))
      {
        $.get('{{ url('user/information') }}/removeproduct/ajax-state?stateid={{ $item->id }}', function(data) {
            window.location.href = "{{ url('user/iwanttosale') }}";
        });
      }
  });
  setTimeout(function(){
      console.log('show productcategorys_id');
      var itemcategory = '{{ $item->id==0? old('productcategorys_id') : $item->productcategorys_id }}';
      if(itemcategory != "")
        $( "#productcategorys_id" ).val({{ $item->id==0? old('productcategorys_id') : $item->productcategorys_id }}).change();
  },500);

</script>
@endpush
@section('content')
@include('shared.usermenu', array('setActive'=>$activemenu))
<br/>
<form enctype="multipart/form-data" class="form-horizontal" role="form" method="post" action="{{ url('user/productedit/'.$item->id) }}">
{{ csrf_field() }}
{{ Form::hidden('product1_file_temp', $item->product1_file) }}
{{ Form::hidden('product2_file_temp', $item->product2_file) }}
{{ Form::hidden('product3_file_temp', $item->product3_file) }}
{{ Form::hidden('users_id', $useritem->id) }}
{{ Form::hidden('iwantto', $useritem->iwantto) }}
<input name="_method" type="hidden" value="PATCH">
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
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
        </div>
        <div class="pull-right">

             <button type="submit" class="btn btn-primary">
               <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
               {{ trans('messages.button_save')}}</button>
             @if($item->id != 0)
             <button id="btnDelete" type="button" class="btn btn-danger">
               <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
               {{ trans('messages.button_delete')}}</button>
             @endif

        </div>
    </div>
</div>
<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6" style="padding-right:30px;">
    <div class="form-group {{ $errors->has('productcategorys_id') ? 'has-error' : '' }}">
        <strong>{{ Lang::get('validation.attributes.productcategorys_id') }}
        :</strong>
        <select id="productcategorys_id" name="productcategorys_id" class="form-control">
            <option value="">{{ trans('messages.menu_product_category') }}</option>
            @foreach ($productCategoryitem as $key => $itemcategory)
              @if($item->productcategorys_id == $itemcategory->id)
                <option selected value="{{ $itemcategory->id }}">{{ $itemcategory->{ "productcategory_title_".Lang::locale()} }}</option>
              @else
                <option value="{{ $itemcategory->id }}">{{ $itemcategory->{ "productcategory_title_".Lang::locale()} }}</option>
              @endif
            @endforeach
        </select>
    </div>
    <div class="form-group {{ $errors->has('products_id') ? 'has-error' : '' }}">
        <strong>{{ Lang::get('validation.attributes.products_id') }}
        :</strong>
        <select id="products_id" name="products_id" class="form-control">
        </select>
    </div>
    <div class="form-group {{ $errors->has('product_title') ? 'has-error' : '' }}">
        <strong>{{ Lang::get('validation.attributes.product_title') }}
        :</strong>
        {!! Form::text('product_title', $item->product_title, array('placeholder' => Lang::get('validation.attributes.product_title'),'class' => 'form-control')) !!}
    </div>
    <div class="form-group {{ $errors->has('product_description') ? 'has-error' : '' }}">
        <strong>{{ Lang::get('validation.attributes.product_description') }}:</strong>
        {!! Form::textarea('product_description', $item->product_description, array('placeholder' => Lang::get('validation.attributes.product_description'),'class' => 'form-control','style'=>'height:100px')) !!}
    </div>
    @if($item->iwantto == "sale")
          <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
              <strong>{{ Lang::get('validation.attributes.price') }}
              :</strong>
              {!! Form::text('price', $item->price, array('placeholder' => Lang::get('validation.attributes.price'),'class' => 'form-control')) !!}
          </div>
          <div class="form-group {{ $errors->has('is_showprice') ? 'has-error' : '' }}">
              <strong>{{ Lang::get('validation.attributes.is_showprice') }}
              :</strong>
              <input value="1" type="checkbox" id="is_showprice" name="is_showprice" {{ $item->is_showprice == 0? '' : 'checked' }}>
          </div>
          <div class="form-group {{ $errors->has('guarantee') ? 'has-error' : '' }}">
              <strong>{{ Lang::get('validation.attributes.guarantee') }}
              :</strong>
              {!! Form::text('guarantee', $item->guarantee, array('placeholder' => Lang::get('validation.attributes.guarantee'),'class' => 'form-control')) !!}
          </div>
          <div class="form-group {{ $errors->has('volumn') ? 'has-error' : '' }}">
              <strong>{{ Lang::get('validation.attributes.volumn') }}
              :</strong>
              {!! Form::text('volumn', $item->volumn, array('placeholder' => Lang::get('validation.attributes.volumn'),'class' => 'form-control')) !!}
          </div>
          <div class="form-group {{ $errors->has('units') ? 'has-error' : '' }}">
              <strong>{{ Lang::get('validation.attributes.units') }}
              :</strong>
              {!! Form::text('units', $item->units, array('placeholder' => Lang::get('validation.attributes.units'),'class' => 'form-control')) !!}
          </div>
    @endif
    <div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
        <strong>{{ Lang::get('validation.attributes.city') }}
        :</strong>
        {!! Form::text('city', $item->city, array('placeholder' => Lang::get('validation.attributes.city'),'class' => 'form-control')) !!}
    </div>
    <div class="form-group {{ $errors->has('province') ? 'has-error' : '' }}">
        <strong>{{ Lang::get('validation.attributes.province') }}
        :</strong>
        {!! Form::text('province', $item->province, array('placeholder' => Lang::get('validation.attributes.province'),'class' => 'form-control')) !!}
    </div>
  </div>
  <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left:30px;">
      @if($item->iwantto == "sale")
          <div class="form-group {{ $errors->has('productstatus') ? 'has-error' : '' }}">
              <strong>{{ Lang::get('validation.attributes.productstatus') }}
              :</strong>
                  <input type="radio" name="productstatus" id="productstatus1" value="open" {{ $item->productstatus == 'open'? 'checked="checked"' : '' }}> Open
                  <input type="radio" name="productstatus" id="productstatus2" value="soldout" {{ $item->productstatus == 'soldout'? 'checked="checked"' : '' }}> Soldout
                  <input type="radio" name="productstatus" id="productstatus3" value="close" {{ $item->productstatus == 'close'? 'checked="checked"' : '' }}> Close
          </div>
          <div class="form-group {{ $errors->has('product1_file') ? 'has-error' : '' }}">
              <strong>{{ Lang::get('validation.attributes.product1_file') }}:</strong>
              {!! Form::file('product1_file', null, array('placeholder' => Lang::get('validation.attributes.product1_file'),'class' => 'form-control')) !!}
          </div>
          <div class="form-group {{ $errors->has('product2_file') ? 'has-error' : '' }}">
              <strong>{{ Lang::get('validation.attributes.product2_file') }}:</strong>
              {!! Form::file('product2_file', null, array('placeholder' => Lang::get('validation.attributes.product2_file'),'class' => 'form-control')) !!}
          </div>
          <div class="form-group {{ $errors->has('product3_file') ? 'has-error' : '' }}">
              <strong>{{ Lang::get('validation.attributes.product3_file') }}:</strong>
              {!! Form::file('product3_file', null, array('placeholder' => Lang::get('validation.attributes.product3_file'),'class' => 'form-control')) !!}
          </div>
          @if($item->product1_file != "")
              <img style="height:260px; width:350px;"  src="{{ url($item->product1_file) }}" alt="" class="img-thumbnail">
          @endif
          @if($item->product2_file != "")
              <img style="height:260px; width:350px;"  src="{{ url($item->product2_file) }}" alt="" class="img-thumbnail">
          @endif
          @if($item->product3_file != "")
              <img style="height:260px; width:350px;"  src="{{ url($item->product3_file) }}" alt="" class="img-thumbnail">
          @endif
      @endif
      @if($item->iwantto == "buy")
          <div class="form-group {{ $errors->has('pricerange_start')||$errors->has('pricerange_end') ? 'has-error' : '' }}">
              <strong>{{ Lang::get('validation.attributes.pricerange_start') }} - {{ Lang::get('validation.attributes.pricerange_end') }}
              :</strong>
              <div class="row">
                <div class="col-sm-6">
                  {!! Form::text('pricerange_start', $item->pricerange_start, array('placeholder' => Lang::get('validation.attributes.pricerange_start'),'class' => 'form-control')) !!}
                </div>
                <div class="col-sm-6">
                  {!! Form::text('pricerange_end', $item->pricerange_end, array('placeholder' => Lang::get('validation.attributes.pricerange_end'),'class' => 'form-control')) !!}
                </div>
              </div>
          </div>
          <div class="form-group {{ $errors->has('volumnrange_start')||$errors->has('volumnrange_end') ? 'has-error' : '' }}">
              <strong>{{ Lang::get('validation.attributes.volumnrange_start') }} - {{ Lang::get('validation.attributes.volumnrange_end') }}
              :</strong>
              <div class="row">
                <div class="col-sm-6">
                  {!! Form::text('volumnrange_start', $item->volumnrange_start, array('placeholder' => Lang::get('validation.attributes.volumnrange_start'),'class' => 'form-control')) !!}
                </div>
                <div class="col-sm-6">
                  {!! Form::text('volumnrange_end', $item->volumnrange_end, array('placeholder' => Lang::get('validation.attributes.volumnrange_end'),'class' => 'form-control')) !!}
                </div>
              </div>
          </div>
          <div class="form-group {{ $errors->has('units') ? 'has-error' : '' }}">
              <strong>{{ Lang::get('validation.attributes.units') }}
              :</strong>
              {!! Form::text('units', $item->units, array('placeholder' => Lang::get('validation.attributes.units'),'class' => 'form-control')) !!}
          </div>
      @endif
  </div>
</div>
</form>
@stop
