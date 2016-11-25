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
<!-- Search -->
 <div class="row searchboxs">
     {!! Form::open(['method'=>'GET','url'=>'result','class'=>'form-inline','role'=>'search'])  !!}
         <div class="form-group">
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
             <input value="{{ Request::input('search') }}" type="text" class="form-control"  id="search" name="search" autocomplete="off">
         </div>
         <button type="submit" class="btn btn-info">{{ trans('messages.menu_search') }}</button>
     {!! Form::close() !!}
 </div>
 <!-- End Search -->
