@if(count($shop) > 0)
    {!! $shop->bank !!}
@else
    {{trans('messages.text_is_not_bank')}}
@endif