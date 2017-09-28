{{--ผู้ขาย ยกเลิกรายการสั่งซื้อ --}}
<div class="col-md-12">
    <div class="row" style="padding: 2px 0px;">
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title" style="display: inline-block;">
                        <a data-toggle="collapse" href="#collapse1">
                            <h3 style="margin-top: 5px;">{{ trans('messages.cancel_list_buy') }}</h3>
                        </a>
                    </h4>
                    <ul class="panel-controls">
                        <li><a data-toggle="collapse" href="#collapse1" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                    </ul>
                </div>
                <div id="collapse1" class="panel-collapse collapse">
                    <div class="panel-body">

                        <form action="{{url('user/orderdetail/store-status-history')}}" id="form_cancled" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="order_id" value="{{$orderId}}">
                            <input type="hidden" name="status_current" value="5">
                            {{csrf_field()}}
                            <div class="form-group ">
                                <strong>* {{ trans('messages.text_note') }}:</strong>
                                <textarea name="note" id="cancled_note" class="form-control" rows="7" style="margin-bottom: 3px;"></textarea>
                                <span id="mss_cancled_note" class="alert-danger"></span>
                            </div>
                            <div class="form-group ">
                                <button class="btn btn-default" type="submit">
                                    <span class="glyphicon glyphicon-floppy-disk"></span>
                                    {{ trans('messages.cancel_list_buy') }}
                                </button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>

    </div>
</div>