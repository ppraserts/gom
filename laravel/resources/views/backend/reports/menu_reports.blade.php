<ul class="nav nav-tabs">
    <li @if(Request::segment(3) == 'buy') class="active" @endif>
        <a href="{{url('user/reports/buy')}}">รายงานการสั่งซื้อ</a>
    </li>
    <li  @if(Request::segment(3) == 'sale') class="active" @endif>
        <a href="{{url('user/reports/sale')}}">รายงานยอดจำหน่ายสินค้า</a>
    </li>
</ul>