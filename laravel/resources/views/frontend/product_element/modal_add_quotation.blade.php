<div id="modal_add_quotaiton" class="modal fade" tabindex="-1" role="dialog" data-keyboard="false"
     data-backdrop="static">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog modal-md vertical-align-center">
            <div class="modal-content">
                <div class="modal-header">
                    <strong>{{trans('messages.quotation_request')}}</strong>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-inline col-md-12">
                            <strong>จำนวนที่ต้องการ</strong>
                            <input type="number" name="quantity" min="1"/>
                            <label>{{$productRequest->units}}</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="addQuotation({{$productRequest['id']}})"><i class="fa fa-shopping-cart"></i> {{trans('messages.quotation_request')}}</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div>