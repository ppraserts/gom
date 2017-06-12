<?php
use App\Http\Controllers\frontend\MarketController;
?>
@extends('layouts.main')
@section('content')
@stop
@push('scripts')
<link href="{{url('jquery-loading/waitMe.css')}}" rel="stylesheet">
<script src="{{url('jquery-loading/waitMe.js')}}"></script>
<script>
    $(function() {
        // none, bounce, rotateplane, stretch, orbit,
        // roundBounce, win8, win8_linear or ios
        var current_effect = 'stretch'; //
        setTimeout(function() {
            run_waitMe2(current_effect);
        }, 2000);
        run_waitMe(current_effect);

        setTimeout(function () {
            $('body').waitMe("hide");
        }, 6000);
        window.location.replace("<?php echo url('result')?>");

    });

    function run_waitMe(effect) {
        $('body').waitMe({
            effect: effect,
//            text: 'Please waiting...',
            text: '<?php echo trans('messages.ms_please_waiting')?>',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000'
        });
    }
    function run_waitMe2(effect) {
        $('body').waitMe({
            effect: effect,
//            text: 'Please waiting...',
            text: 'อัพเดทข้อมูลเรียบร้อยระบบกำลังนำท่านเข้าสู่หน้าหลัก',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000'
        });
    }
</script>
@endpush
