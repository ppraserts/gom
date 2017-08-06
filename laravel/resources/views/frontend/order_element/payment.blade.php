{{--แจ้งชำระเงิน--}}
<div class="col-md-12" style="background: rgba(255, 235, 59, 0.18); margin-bottom: 15px;">
    <div class="row" style="padding: 17px 15px;">
        <h3 style="margin-top: 5px;">{{ trans('messages.text_push_payment')}}</h3>
        <form action="{{url('user/orderdetail/store-status-history')}}" method="POST" id="form-image_payment"
              data-toggle="validator" role="form" enctype="multipart/form-data">
            <input type="hidden" name="order_id" value="{{$orderId}}">
            <input type="hidden" name="status_current" value="3">
            {{csrf_field()}}
            <div class="input-group form-group">
                <strong>
                    * {{ trans('messages.text_image_payment')}}
                    <span class="alert-danger"> {{trans('validation.attributes.message_validate_type_payment')}}</span> :
                </strong>
                <input type="file" name="payment_image" id="payment_image">
                <div class="help-block with-errors"></div>
                <small class="alert-danger" id="ms_payment_image"></small>
            </div>
            <div class="form-group ">
                <strong>{{ trans('messages.text_note') }}:</strong>
                <textarea name="note" class="form-control" rows="7"></textarea>
            </div>
            @if(!empty($order->address_delivery) and $order->address_delivery != 'undefined')
            <div class="form-group">
                <h3 style="margin-top: 5px;">ข้อมูลการจัดส่ง</h3>
                <table class="table table-bordered table-striped table-hover">
                    <tr>
                        <td>เลือก</td>
                        <td>ช่องทางการจัดส่ง</td>
                        <td>ค่าจัดส่ง (บาท)</td>
                        <td>ยอดสุทธิ (ค่าสินค้า + ค่าจัดส่ง)</td>
                    </tr>
                    @if(count($orderDeliverys) > 0)
                        <?php $countArr = 1;?>
                        @foreach($orderDeliverys as $orderDelivery)
                            @if($orderDelivery->selected == 1)
                                <tr>
                                    <td class="text-center">
                                        <input type="radio" name="user_buy_id" value="{{$orderDelivery->id}}" @if($countArr == 1) checked @endif>
                                    </td>
                                    <td>
                                        {{$orderDelivery->shipping_channel}}
                                    </td>
                                    <td>
                                        {{$orderDelivery->delivery_charge}}
                                    </td>
                                    <td>
                                        {{$orderDelivery->sum_delivery_charge}}
                                    </td>
                                </tr>
                                <?php $countArr++;?>
                            @endif

                        @endforeach
                    @endif
                </table>

            </div>
            @endif
            <div class="form-group ">
                <button class="btn btn-default" type="submit">
                    <span class="glyphicon glyphicon-floppy-disk"></span>
                    {{ trans('messages.button_save')}}
                </button>
            </div>
        </form>
    </div>
</div>