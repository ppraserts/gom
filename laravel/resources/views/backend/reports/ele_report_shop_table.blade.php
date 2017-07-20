<div class="row" style="margin-top: 10px">
    @if(count($shops) > 0 && count($errors) <1)
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" style="font-size: 13px;">
                <thead>
                <tr>
                    <th width="120px" style="text-align:center;">{{trans('messages.province')}}</th>
                    <th style="text-align:center;">{{trans('messages.shop')}}</th>
                    <th style="text-align:center;">{{trans('messages.sum_prict_order')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($shops as $shop)
                    <tr>
                        <td>{{ $shop->users_province }}</td>
                        <td>{{ $shop->shop_name }}</td>
                        <td>{{ number_format($shop->total) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    @else
        <div class="alert alert-warning text-center">
            <strong>{{trans('messages.data_not_found')}}</strong>
        </div>
    @endif
</div>
@if(count($shops) > 0)
    <div class="row">
        <div class="col-md-6">{!! $shops->appends(Request::all()) !!}</div>
        <div class="col-md-6">
            <div class="col-md-12" style="padding-left: 0; padding-right: 0; margin-top: 20px;">
                <button class="btn btn-primary pull-right" id="export" type="button">
                    <span class="glyphicon glyphicon-export"></span>
                    {{ trans('messages.export_excel') }}
                </button>
            </div>
        </div>
    </div>
@endif