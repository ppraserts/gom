@if(count($products))
    <option value="">
        {{ trans('messages.select_product_type_name') }}
    </option>
    @foreach($products as $product)
        <option value="{{$product->id}}" @if(!empty($productTypeNameArr)) @if(in_array($product->id, $productTypeNameArr)) selected @endif @endif>
            {{$product->product_name_th}}
        </option>
    @endforeach
@else
    <option value="">
        {{ trans('messages.data_not_found') }}
    </option>
@endif