<ul class="nav nav-tabs">
    <li @if(Request::segment(3) == 'buy') class="active" @endif>
        <a href="{{url('admin/reports/buy')}}">รายงานการสั่งซื้อ</a>
    </li>
    <li  @if(Request::segment(3) == 'sale') class="active" @endif>
        <a href="{{url('admin/reports/sale')}}">รายงานยอดจำหน่ายสินค้า</a>
    </li>
    <li  @if(Request::segment(3) == 'salebyshop') class="active" @endif>
        <a href="{{url('admin/reports/salebyshop')}}">รายงานยอดจำหน่ายร้านค้า</a>
    </li>
    <li  @if(Request::segment(3) == 'shop') class="active" @endif>
        <a href="{{url('admin/reports/shop')}}">รายงานร้านค้ายอดนิยม</a>
    </li>
    <li  @if(Request::segment(3) == 'product') class="active" @endif>
        <a href="{{url('admin/reports/product')}}">รายงานสินค้ายอดนิยม</a>
    </li>
    <li  @if(Request::segment(3) == 'orders') class="active" @endif>
        <a href="{{url('admin/reports/orders')}}">
            {{ trans('messages.text_report_menu_order_status_history') }}
        </a>
    </li>
    <li  @if(Request::segment(3) == 'y') class="active" @endif>
        <a href="#">รายงานการจับคู่สินค้า</a>
    </li>
    <li  @if(Request::segment(3) == 'order-history-sale-buy') class="active" @endif>
        <a href="{{url('admin/reports/order-history-sale-buy')}}">
            {{ trans('messages.text_report_menu_order_history_sale_buy') }}
        </a>
    </li>
</ul>