@push('scripts')
<script type="text/javascript">
$(function()
{
	 var query_url = '';
	 var products;

	query_url = '{{url('/information/create/ajax-state')}}';

	products = new Bloodhound({
		datumTokenizer: function (datum) {
			alert(datum);
			return Bloodhound.tokenizers.obj.whitespace(datum.id);
		},
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		remote: {
			url: query_url+'?search=true&product_name_th=%QUERY',
			filter: function (products) {
				// Map the remote source JSON array to a JavaScript object array
				return $.map(products, function (product) {
					return {
						id: product.id,
						value: product.product_name_th
					};
				});
			},
			wildcard: "%QUERY"
		}
	});
	
	products.initialize();

	$('.typeahead').typeahead({
		hint: false,
		highlight: true,
		minLength: 1,
		autoSelect: true
		}, {
		limit: 60,
		name: 'product_id',
		displayKey: 'value',
		source: products.ttAdapter(),
		templates: {
			header: '<div style="text-align: center;">{{trans('messages.baht')}}</div><hr style="margin:3px; padding:0;" />'
		}
	});

	 $('#productcategorys_id').on('change', function(e){
		product_category_value = e.target.value;

		query_url = '{{url('/information/create/ajax-state?search=true&productcategorys_id=')}}'+product_category_value;

		products = new Bloodhound({
			datumTokenizer: function (datum) {
				alert(datum);
				return Bloodhound.tokenizers.obj.whitespace(datum.id);
			},
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			remote: {
				url: query_url+'&product_name_th=%QUERY',
				filter: function (products) {
					// Map the remote source JSON array to a JavaScript object array
					return $.map(products, function (product) {
						return {
							id: product.id,
							value: product.product_name_th
						};
					});
				},
				wildcard: "%QUERY"
			}
		});
		
		products.initialize();

		$('.typeahead').typeahead('destroy');
		$('.typeahead').typeahead({
			hint: false,
			highlight: true,
			minLength: 1,
			autoSelect: true
			}, {
			limit: 60,
			name: 'product_id',
			displayKey: 'value',
			source: products.ttAdapter(),
			templates: {
				header: '<div style="text-align: center;">{{trans('messages.product_name')}}</div><hr style="margin:3px; padding:0;" />'
			}
		});
	 });


	$('.typeahead').bind('typeahead:select', function(ev, suggestion) {
		$('#products_id').val(suggestion.id);
	});

});
</script>
@endpush
<!-- Search -->
 <div class="row searchboxs">
     {!! Form::open(['method'=>'GET','url'=>'result','class'=>'form-inline','role'=>'search'])  !!}
         <div class="form-group">
             <select class="form-control" id="productcategorys_id" name="category">
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
             <input value="{{ Request::input('search') }}" type="text" class="form-control typeahead"  id="search" name="search" autocomplete="off">
         </div>
         <button type="submit" class="btn btn-info">{{ trans('messages.menu_search') }}</button>
         <a href="{{ url('/advancesearch') }}">ค้นหาขั้นสูง</a>
     {!! Form::close() !!}
 </div>
 <!-- End Search -->
