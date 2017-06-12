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
        run_waitMe(current_effect);
        setTimeout(function () {
            $('body').waitMe("hide");
        }, 3000);
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
</script>
@endpush
