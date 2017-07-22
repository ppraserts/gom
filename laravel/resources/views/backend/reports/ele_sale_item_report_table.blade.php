<div class="row" style="margin-top: 10px">
    @if(count($orderSaleItem) > 0 && count($errors) <1)
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" style="font-size: 13px;">
                <thead>
                <tr>
                    <th>{{trans('messages.menu_market')}}</th>
                    <th style="text-align:center;">{{trans('messages.product_name')}}</th>
                    <th style="text-align:center;">{{trans('messages.sum_prict_order')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orderSaleItem as $item)
                    <tr>
                        <td>
                            @foreach($item->markets as $market)
                                <p>- {{$market->market_name}}</p>
                            @endforeach
                        </td>
                        <td>{{ $item->product_name_th }}</td>
                        <td style="text-align:center;">{{ number_format($item->total) }}</td>
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
@if(count($orderSaleItem) > 0)
    <div class="row">
        <div class="col-md-6">{!! $orderSaleItem->appends(Request::all()) !!}</div>
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

@push('scripts')
<script src="{{url('jquery-plugin-for-bootstrap-loading-modal/build/bootstrap-waitingfor.js')}}"></script>
<script type="text/javascript">
    $("#export").click(function () {
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        var market_id = $("#market_id").val();
        //var product_type_name = $("#product_type_name option:selected").val();
        var product_type_name = [];
        $('#product_type_name option:selected').each(function (i, selected) {
            product_type_name[i] = $(selected).val();
        });
        waitingDialog.show('<?php echo trans('messages.text_loading_lease_wait')?>', {
            progressType: 'success'
        });
        var productcategorys_id =$('#productcategorys_id option:selected').val();
        var key_token = $('input[name=_token]').val();
        $.ajax({
            headers: {'X-CSRF-TOKEN': key_token},
            type: "POST",
            url: "<?php $page = ''; if (!empty(Request::input('page'))) {
                $page = '?page=' . Request::input('page');
            } echo url('user/reports/saleitem/export' . $page)?>",
            data: {start_date: start_date, end_date: end_date, product_type_name: product_type_name,productcategorys_id:productcategorys_id,market_id:market_id},
            success: function (response) {
                $('.modal-content').empty();
                $('.modal-content').html('<div class="modal-body text-center"><button class="btn btn-info a-download" id="btn-download" style="margin-right: 5px;"><?php echo trans('messages.download')?></button><button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo trans('messages.btn_close')?></button></div>');
                $(".a-download").click(function () {
                    waitingDialog.hide();
                    window.open(
                        "<?php echo url('user/reports/buy/download/?file=')?>" + response.file,
                        '_blank'
                    );
                });
                return false;
            },
            error: function (response) {
                alert('error..');
                return false;
            }
        })
    });
</script>
@endpush
