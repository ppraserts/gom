<ul class="nav nav-tabs">
    <li @if(Request::segment(3) == 'buy') class="active" @endif>
        <a href="{{url('user/reports/buy')}}">{{ trans('messages.menu_order_list') }}</a>
    </li>
    <li @if(Request::segment(3) == 'list-sale') class="active" @endif>
        <a href="{{url('user/reports/list-sale')}}">{{ trans('messages.menu_shop_order_list') }}</a>
    </li>
    <li  @if(Request::segment(3) == 'sale') class="active" @endif>
        <a href="{{url('user/reports/sale')}}">รายงานยอดจำหน่ายสินค้า</a>
    </li>
</ul>