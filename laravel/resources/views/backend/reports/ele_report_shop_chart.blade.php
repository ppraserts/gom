<div class="row" style="margin-top: 10px">
    @if(count($shops) > 0 && count($errors) < 1)
        <div id="container" style="min-width: 400px; height: auto; margin: 0px auto; padding-top:2%;"></div>
    @else
        <div class="alert alert-warning text-center">
            <strong>{{trans('messages.data_not_found')}}</strong>
        </div>
    @endif
</div>