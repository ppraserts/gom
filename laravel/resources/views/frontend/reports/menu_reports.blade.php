<?php
$user = auth()->guard('user')->user();
$cshop = array();
if(count($user) > 0){
    if(!empty($user->iwanttosale)){
        $cshop = DB::table('shops')->where('user_id', $user->id)->first();
    }
}
?>
<ul class="nav nav-tabs">
    @if($user->iwanttobuy == "buy")
    <li @if(Request::segment(3) == 'buy') class="active" @endif>
        <a href="{{url('user/reports/buy')}}">{{ trans('messages.report_order') }}</a>
    </li>
    @endif
    @if($user->iwanttosale == "sale")
        @if(count($cshop) > 0)
            <li @if(Request::segment(3) == 'list-sale') class="active" @endif>
                <a href="{{url('user/reports/list-sale')}}">{{ trans('messages.report_sale') }}</a>
            </li>
            <li  @if(Request::segment(3) == 'sale') class="active" @endif>
                <a href="{{url('user/reports/sale')}}">{{trans('messages.report_title_sale')}}</a>
            </li>
         @endif
    @endif
</ul>