@if(count($order_delivery) > 0)
        <div class="col-md-12" style="width: 700px;">
            <div class="row">
                <h3>{{ trans('messages.shipping_information') }}</h3>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <td>{{ trans('messages.selected') }}</td>
                            <td>{{ trans('messages.text_delivery_channel') }}</td>
                            <td>{{ trans('messages.delivery_price') }}</td>
                            <td>{{ trans('messages.net_balance_shipping') }}</td>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align:center;"><input type="checkbox" @if($order_delivery->selected == 1)checked @endif disabled></td>
                                <td style="text-align:center;">{{$order_delivery->shipping_channel}}</td>
                                <td style="text-align:left; max-width: 400px;">{{$order_delivery->delivery_charge}}</td>
                                <td style="text-align:left; max-width: 400px;">{{$order_delivery->sum_delivery_charge}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endif