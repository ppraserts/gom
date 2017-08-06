@if(count($orderDeliverys) > 0)
    <div class="row">
        <div class="col-md-12">
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
                        @foreach ($orderDeliverys as $orderDelivery)
                            <tr>
                                <td style="text-align:center;"><input type="checkbox" @if($orderDelivery->selected == 1)checked @endif disabled></td>
                                <td style="text-align:center;">{{$orderDelivery->shipping_channel}}</td>
                                <td style="text-align:left; max-width: 400px;">{{$orderDelivery->delivery_charge}}</td>
                                <td style="text-align:left; max-width: 400px;">{{$orderDelivery->sum_delivery_charge}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif