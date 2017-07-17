<?php
$user = auth()->guard('user')->user();
?>
<ul class="nav nav-tabs">
    @if($user->iwanttobuy == "buy")
    <li @if(Request::segment(3) == 'buy') class="active" @endif>
        <a href="{{url('user/reports/buy')}}">{{ trans('messages.menu_order_list') }}</a>
    </li>
    @endif
    @if($user->iwanttosale == "sale")
    <li @if(Request::segment(3) == 'list-sale') class="active" @endif>
        <a href="{{url('user/reports/list-sale')}}">{{ trans('messages.menu_shop_order_list') }}</a>
    </li>
    <li  @if(Request::segment(3) == 'sale') class="active" @endif>
        <a href="{{url('user/reports/sale')}}">{{trans('messages.report_title_sale')}}</a>
    </li>
    @endif
</ul>