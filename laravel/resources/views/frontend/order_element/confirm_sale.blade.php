{{--ผู้ขาย ยืนยันการสั่งซื้อ--}}
<div class="col-md-12" style="background: rgba(255, 235, 59, 0.18); margin-bottom: 10px;">
    <div class="row" style="padding: 17px 15px;">
        <h3 style="margin-top: 5px;">{{trans('messages.confirm_order')}}</h3>
        <form action="{{url('user/orderdetail/store-status-history')}}" id="form_payment_channel" method="POST">
            <input type="hidden" name="order_id" value="{{$orderId}}">
            <input type="hidden" name="status_current" value="2">
            {{csrf_field()}}
            <div class="form-group">
                <strong>{{ trans('messages.text_payment_channel') }}:</strong>
                <select name="payment_channel" id="payment_channel">
                    <option value="">* {{trans('messages.select_payment_gateway')}}</option>
                    <option value="บัญชีธนาคาร">{{trans('messages.book_bank')}}</option>
                    <option value="เงินสด">{{trans('messages.cash')}}</option>
                </select>
                <small class="alert-danger" id="ms_payment_channel"></small>
            </div>
            <div class="form-group" id="html_payment_channel">
            </div>
            <div class="form-group">
                <strong>* {{ trans('messages.text_note') }}:</strong>
                <textarea name="note" id="note" class="form-control" rows="7"></textarea>
            </div>
            @if(!empty($order->address_delivery) and $order->address_delivery != 'undefined')
            <div class="form-group">
                <h3 style="margin-top: 5px;">{{ trans('messages.shipping_information') }}</h3>
                <table class="table table-bordered table-striped table-hover">
                    <tr>
                        <td>{{ trans('messages.selected') }}</td>
                        <td>{{ trans('messages.text_delivery_channel') }}</td>
                        <td>{{ trans('messages.delivery_price') }}</td>
                        <td>{{ trans('messages.net_balance_shipping') }}</td>
                    </tr>
                    @if(count($shopdeliverys) > 0)
                        <?php $i=1;?>
                        @foreach($shopdeliverys as $shopdelivery)
                            <tr>
                                <td class="text-center"><input type="checkbox" name="selected[]" value="{{$i}}"></td>
                                <td>
                                    <input type="text" name="shipping_channel[]" class="form-control" value="{{$shopdelivery->delivery_name}}">
                                </td>
                                <td>
                                    <input type="number" name="delivery_charge[]" class="form-control" value="{{$shopdelivery->delivery_price}}" onkeyup="DeliveryCharge(this.value,'{{$shopdelivery->id}}')">
                                </td>
                                <td>
                                    <span id="sum_delivery_price_{{$shopdelivery->id}}">
                                        {{$shopdelivery->delivery_price+$order->total_amount}}
                                    </span>
                                    <input type="hidden" id="input_sum_delivery_price_{{$shopdelivery->id}}" name="sum_delivery_price[]" value="{{$shopdelivery->delivery_price+$order->total_amount}}">
                                </td>
                            </tr>
                            <?php $i++;?>
                        @endforeach
                    @endif
                </table>
                <small class="alert-danger" id="ms_order_delivery"></small>
            </div>
            @endif
            <div class="form-group ">
                <button class="btn btn-default" type="submit">
                    <span class="glyphicon glyphicon-floppy-disk"></span>
                    {{ trans('messages.text_confirm_payment') }}
                </button>
            </div>
        </form>
    </div>
</div>