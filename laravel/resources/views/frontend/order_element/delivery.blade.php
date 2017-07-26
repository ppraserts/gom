{{--ผู้ขาย จัดส่งแล้ว --}}
<div class="col-md-12" style="background: rgba(255, 235, 59, 0.18); margin-bottom: 15px;">
    <div class="row" style="padding: 17px 15px;">
        <h3 style="margin-top: 5px;">{{ trans('messages.text_transport_product') }}</h3>
        <form action="{{url('user/orderdetail/store-status-history')}}" id="delivery_form" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="order_id" value="{{$orderId}}">
            <input type="hidden" name="status_current" value="4">
            {{csrf_field()}}

            <div class="form-group ">
                <strong> * {{trans('messages.shipping_type')}} :</strong>
                <input type="text" id="delivery_chanel" name="delivery_chanel" class="form-control" style="margin-bottom: 5px; width: 320px;">
                <span id="mss_delivery_chanel" class="alert-danger"></span>
            </div>
            <div class="form-group ">
                <strong> * {{trans('messages.shipping_date')}} :</strong>
                <div class='input-group date' id='pick_start_date' style="margin-bottom: 5px; width: 320px;">
                    <input  class="form-control" id="order_date" name="order_date" type="text" value="">
                    <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                <span id="mss_order_date" class="alert-danger"></span>
            </div>
            <div class="input-group">
                <strong> * {{ trans('messages.text_image_delivery') }} :</strong>
                <input type="file" name="delivery_image" id="delivery_image">
                <small class="alert-danger" id="ms_delivery_image"></small><br/>
            </div>

            <div class="form-group ">
                <strong> {{ trans('messages.text_note') }}:</strong>
                <textarea name="note" class="form-control" rows="7"></textarea>
            </div>
            <div class="form-group ">
                <button class="btn btn-default" type="submit">
                    <span class="glyphicon glyphicon-floppy-disk"></span>
                    {{ trans('messages.text_transport') }}
                </button>
            </div>
        </form>
    </div>
</div>