<ul class="nav nav-tabs">
    <li @if(Request::segment(3) == 'buy') class="active" @endif>
        <a href="{{url('admin/reports/buy')}}">รายงานการสั่งซื้อ</a>
    </li>
    <li  @if(Request::segment(3) == 'sale') class="active" @endif>
        <a href="{{url('user/reports/sale')}}">รายงานยอดจำหน่ายสินค้า</a>
    </li>
    <li  @if(Request::segment(3) == 'shop') class="active" @endif>
        <a href="{{url('admin/reports/shop')}}">{{trans('messages.text_report_menu_shop')}}</a>
    </li>
    <li  @if(Request::segment(3) == 'product') class="active" @endif>
        <a href="{{url('admin/reports/product')}}">รายงานสินค้ายอดนิยม</a>
    </li>
    <li  @if(Request::segment(3) == 'product') class="active" @endif>
        <a href="{{url('user/reports/product')}}">รายงานติดตามสถานะสั่งซื้อสินค้า</a>
    </li>
    <li  @if(Request::segment(3) == 'product') class="active" @endif>
        <a href="{{url('user/reports/product')}}">รายงานการจับคู่สินค้า</a>
    </li>
    <li  @if(Request::segment(3) == 'product') class="active" @endif>
        <a href="{{url('user/reports/product')}}">รายงานประวัติการซื้อขาย</a>
    </li>
</ul>