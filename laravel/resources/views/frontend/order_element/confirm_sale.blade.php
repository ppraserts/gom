{{--ผู้ขาย ยืนยันการสั่งซื้อ--}}
<div class="col-md-12" style="background: rgba(255, 235, 59, 0.18); margin-bottom: 10px;">
    <div class="row" style="padding: 17px 15px;">
        <h3 style="margin-top: 5px;">ยืนยันการสั่งซื้อ</h3>
        <form action="{{url('user/orderdetail/store-status-history')}}" method="POST">
            <input type="hidden" name="order_id" value="{{$orderId}}">
            <input type="hidden" name="status_current" value="2">
            {{csrf_field()}}
            <div class="form-group">
                <strong>{{ trans('messages.text_payment_channel') }}:</strong>
                <select name="payment_channel" id="payment_channel">
                    <option value="">กรุณาเลือกช่องทางการชำระเงิน</option>
                    <option value="บัญชีธนาคาร">บัญชีธนาคาร</option>
                    <option value="เงินสด">เงินสด</option>
                </select>
            </div>
            <div class="form-group" id="html_payment_channel">
            </div>
            <div class="form-group">
                <strong>* {{ trans('messages.text_note') }}:</strong>
                <textarea name="note" id="note" class="form-control" rows="7"></textarea>
            </div>
            <div class="form-group ">
                <button class="btn btn-default" type="submit">
                    <span class="glyphicon glyphicon-floppy-disk"></span>
                    {{ trans('messages.text_confirm_payment') }}
                </button>
            </div>
        </form>
    </div>
</div>