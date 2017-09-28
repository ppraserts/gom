<?php
$result_user = auth()->guard('user')->user();
$shop = array();
if(count($result_user) > 0){
    if(!empty($result_user->iwanttosale)){
        $shop = DB::table('shops')->where('user_id', $result_user->id)->first();
    }
}
?>
@if(count($shop) <= 0)
    <div class="row">
        <div class="col-sm-12 text-center" style="margin-bottom: 15px;">
            <div class="alert alert-danger" style="font-size: 16px;">
                {{ trans('messages.please_input_information_shop') }}
            </div>
        </div>
    </div>
@endif