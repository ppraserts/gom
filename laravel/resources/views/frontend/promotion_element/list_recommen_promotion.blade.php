<div class="row" style="margin-top: 20px">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h3>{{ trans('messages.text_list_recomment_promotion') }}</h3>
        </div>
    </div>
</div>
<div class="row" style="margin-top: 10px">
    <div class="col-lg-12 margin-tb">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>{{ trans('messages.text_date') }}</th>
                    <th>{{ trans('messages.text_count_email') }}</th>
                    <th width="360px">{{ trans('messages.Description') }}</th>
                    <th width="160px">{{ trans('messages.text_count_read_recomment_promotion') }}</th>
                </tr>
                </thead>
                <tbody>
                @if(count($promotion_recommends) > 0)
                    @foreach ($promotion_recommends as $recommend)
                        <tr>
                            <td>{{ $recommend->recommend_date }}</td>
                            <td>{{ $recommend->count_email }}</td>
                            <td>{{ mb_strimwidth($recommend->detail, 0, 150, '...', 'UTF-8') }}</td>
                            <td>{{ $recommend->sum_recommend }}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
            @if(count($promotion_recommends) > 0)
                {!! $promotion_recommends->appends(Request::all()) !!}
            @endif
        </div>
    </div>
</div>