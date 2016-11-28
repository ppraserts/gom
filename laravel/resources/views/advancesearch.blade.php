@extends('layouts.main')
@push('scripts')
<script type="text/javascript">
$(document).ready(function(){
  var $input = $('#search');
  $input.typeahead({
      displayText: function (item) {
        return item.name;
      }
      , display: 'product_title', val: 'product_title'
      ,source: function(search, response){
        $.get('{{ url('information') }}/create/ajax-state?query=' + search, function(data) {
            response(data);
        });
      },
      autoSelect: true
  });
});
</script>
@endpush
@section('content')
<div class="row">
  <!-- Search -->
   <div class="row">
       {!! Form::open(['method'=>'GET','url'=>'result','class'=>'','role'=>'search'])  !!}
        <div class="col-md-6">
           <div class="form-group">
               <label>{{ trans('messages.menu_product_category') }}</label>
               <select class="form-control" id="category" name="category">
                   <option value="">{{ trans('messages.menu_product_category') }}</option>
                   @foreach ($productCategoryitem as $key => $item)
                     @if(Request::input('category') == $item->id)
                       <option selected value="{{ $item->id }}">{{ $item->{ "productcategory_title_".Lang::locale()} }}</option>
                     @else
                       <option value="{{ $item->id }}">{{ $item->{ "productcategory_title_".Lang::locale()} }}</option>
                     @endif
                   @endforeach
               </select>
           </div>
           <div class="form-group">
              <label>{{ Lang::get('validation.attributes.province')  }}</label>
               <select class="form-control" id="province" name="province">
                   <option value="">{{ Lang::get('validation.attributes.province') }}</option>
                   @foreach ($provinceItem as $key => $item)
                     @if(Request::input('province') == $item->PROVINCE_NAME)
                       <option selected value="{{ $item->PROVINCE_NAME }}">{{ $item->PROVINCE_NAME }}</option>
                     @else
                       <option value="{{ $item->PROVINCE_NAME }}">{{ $item->PROVINCE_NAME }}</option>
                     @endif
                   @endforeach
               </select>
           </div>
        </div>
        <div class="col-md-6">
           <div class="form-group">
               <label>{{ trans('messages.menu_product') }}</label>
               <input value="{{ Request::input('search') }}" type="text" class="form-control"  id="search" name="search" autocomplete="off">
           </div>
           <div class="form-group">
               <label>{{ trans('messages.searchprice') }}</label>
               <input value="{{ Request::input('price') }}" type="text" class="form-control"  id="price" name="price" autocomplete="off">
           </div>
           <div class="form-group">
               <label>{{ Lang::get('validation.attributes.volumn') }}</label>
               <input value="{{ Request::input('volumn') }}" type="text" class="form-control"  id="volumn" name="volumn" autocomplete="off">
           </div>
           <button type="submit" class="btn btn-info">{{ trans('messages.menu_search') }}</button>
      </div>
       {!! Form::close() !!}
   </div>
   <!-- End Search -->
</div>
@stop
