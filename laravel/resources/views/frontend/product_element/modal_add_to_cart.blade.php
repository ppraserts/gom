<div id="modal_add_to_cart" class="modal fade" tabindex="-1" role="dialog" data-keyboard="false"
     data-backdrop="static">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog modal-md vertical-align-center">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-success" style="color: #00cc66"> สินค้า
                        ได้ถูกเพิ่มเข้าไปยังตะกร้าสินค้าของคุณ</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="col-md-4">
                                <img class="text-center" id="img_product" width="150" height="120">
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div id="div_product_description"></div>
                                    <div id="div_product_title"></div>
                                    <div id="div_product_price"></div>
                                    <p>ราคาต่อหน่วย(บาท) : <span id="sp_product_price"></span></p>
                                    {{--<p>ปริมาณ (<span id="units"></span>) : <span id="sp_product_volume"></span></p>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{url('user/shoppingcart') }}" type="button"
                       class="btn btn-success"><i class="fa fa-shopping-cart"></i> {{trans('messages.add_to_cart')}}</a>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{trans('messages.close')}}</button>
                </div>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div>