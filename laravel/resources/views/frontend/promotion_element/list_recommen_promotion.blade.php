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
                    <th>{{ trans('messages.text_email') }}</th>
                    <th width="360px">{{ trans('messages.Description') }}</th>
                    <th width="160px">{{ trans('messages.text_count_read_recomment_promotion') }}</th>
                </tr>
                </thead>
                <tbody>
                @if(count($pormotion_recomments) > 0)
                    @foreach ($pormotion_recomments as $recomment)
                        <tr>
                            <td>{{ $recomment->recommend_date }}</td>
                            <td>{{ $recomment->email }}</td>
                            <td>{{ mb_strimwidth($recomment->detail, 0, 150, '...', 'UTF-8') }}</td>
                            <td>{{ $recomment->count_recommend }}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
            @if(count($pormotion_recomments) > 0)
                {!! $pormotion_recomments->appends(Request::all()) !!}
            @endif
        </div>
    </div>
</div>