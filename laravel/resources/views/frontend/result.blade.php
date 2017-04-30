<?php
use App\Http\Controllers\frontend\MarketController;
?>
@extends('layouts.main')
@section('content')
    @include('shared.search')
    <br/>
    <h3>{{ trans('messages.i_want_to_sale') }}</h3>
    @if(count((array)$itemssale)>0)
        <div class="row">
            <?php
            $arr = (array)$itemssale;
            foreach(array_chunk($arr, 3, true) as $div_item)
            {
            foreach ($div_item as $col_md_4_items)
            {
            $col_md_4_item = (array)$col_md_4_items;

            $product_name = MarketController::get_product_name($col_md_4_item['products_id']);

            $imageName_temp = iconv('UTF-8', 'tis620', $col_md_4_item['product1_file']);
            if (!file_exists($imageName_temp)) {
                $col_md_4_item['product1_file'] = '/images/default.jpg';
            }
            ?>
            <div class="col-md-3" title="{{ $col_md_4_item['created_at'] }}">
                <div class="col-item">
                    <div class="photo crop-height">
                        <img src="{{ url($col_md_4_item['product1_file']) }}" class="scale" alt="a">
                    </div>
                    <div class="info">
                        <div class="row">
                            <div class="price col-md-8">
                                <h4 title="{{ $product_name }}"><?php echo mb_strimwidth($product_name, 0, 15, '...', 'UTF-8'); ?></h4>
                                <span class="glyphicon glyphicon-tag"></span>
                                <i title="{{ $product_name }}"><?php echo mb_strimwidth($col_md_4_item['product_title'], 0, 15, '...', 'UTF-8'); ?></i><br/>
                                <span class="glyphicon glyphicon-map-marker"></span>
                                {{ $col_md_4_item['city'] }} {{ $col_md_4_item['province'] }}
                                <br/><br/>
                            </div>
                            <div class="rating hidden-sm col-md-4">
                                <a href="#" onclick="addToCart('{{$col_md_4_item['id']}}' , '{{$col_md_4_item['users_id']}}' , '{{$col_md_4_item['price']}}')" class="btn btn-primary"><i class="fa fa-shopping-cart"></i></a>
                            </div>
                        </div>
                        <div class="separator clear-left">
                            <p class="btn-add">
                                <span class="hidden-sm">  {{ $col_md_4_item['is_showprice']? floatval($col_md_4_item['price']) : trans('messages.product_no_price') }}</span>
                            </p>
                            <p class="btn-details">
                                <i class="fa fa-list"></i>
                                <a href="{{ url('user/productview/'.$col_md_4_item['id']) }}" class="hidden-sm">{{ trans('messages.button_moredetail')}}</a></p>
                        </div>
                        <div class="clearfix">
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            }
            ?>
        </div>
    @else
        <div style="text-align:center; padding:20px;">
            <h1>
                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                {{ trans('messages.noresultsearch') }}
            </h1>
        </div>
    @endif
    <br/>
    <h3>{{ trans('messages.i_want_to_buy') }}</h3>
    @if(count((array)$itemsbuy)>0)
        <div class="row">
            <?php
            $arr = (array)$itemsbuy;
            foreach(array_chunk($arr, 3, true) as $div_item)
            {
            foreach ($div_item as $col_md_4_items)
            {
            $col_md_4_item = (array)$col_md_4_items;
            ?>
            <div class="col-md-3" title="{{ $col_md_4_item['created_at'] }}">
                <div class="col-item">
                    <div class="info">
                        <div class="row">
                            <div class="price col-md-9">
                                <h4>{{ $col_md_4_item['product_title'] }} : {{ floatval($col_md_4_item['volumnrange_start']) }}
                                    - {{ floatval($col_md_4_item['volumnrange_end']) }} {{ $col_md_4_item['units'] }}</h4>
                                <span class="glyphicon glyphicon-map-marker"></span>
                                {{ $col_md_4_item['city'] }} {{ $col_md_4_item['province'] }}
                                <br/><br/>
                            </div>
                            <div class="rating hidden-sm col-md-3">
                            </div>
                        </div>
                        <div class="separator clear-left">
                            <p class="btn-add">
                                <span class="hidden-sm">THB {{ floatval($col_md_4_item['pricerange_start']) }}
                                    - {{ floatval($col_md_4_item['pricerange_end']) }}</span>
                            </p>
                            <p class="btn-details">
                                <i class="fa fa-list"></i>
                                <a href="{{ url('user/productview/'.$col_md_4_item['id']) }}" class="hidden-sm">{{ trans('messages.button_moredetail')}}</a></p>
                        </div>
                        <div class="clearfix">
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            }
            ?>
        </div>
    @else
        <div style="text-align:center; padding:20px;">
            <h1>
                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                {{ trans('messages.noresultsearch') }}
            </h1>
        </div>
    @endif



    <!-- modal product added to cart -->
    <div id="modal_add_to_cart" class="modal fade" tabindex="-1" role="dialog" data-keyboard="false"
         data-backdrop="static">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog modal-md vertical-align-center">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-success" style="color: #00cc66"> สินค้า 1 ชิ้น
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
                                        <p>ปริมาณ : <span id="sp_product_volume"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{url('user/shoppingcart') }}" type="button"
                           class="btn btn-success"><i class="fa fa-shopping-cart"></i> ตะกร้าสินค้า</a>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->

@stop

@push('scripts')

<script>

    var BASE_URL = '<?php echo url('/')?>';

    $(document).ready(function () {
        $('#modal_add_to_cart').on('hidden.bs.modal', function () {
            location.reload();
        });
    });

    function addToCart(productRequestId , userId , unit_price) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var targetUrl = BASE_URL + '/user/shoppingcart/addToCart';
        $.ajax({
            type: 'POST',
            url: targetUrl,
            data: {_token: CSRF_TOKEN, product_request_id: productRequestId , user_id: userId , unit_price: unit_price},
            dataType: 'json',
            success: function (response) {
                if (response.status == 'success') {
                    showProductAdded(response.product_request);
                }else{
                    window.location = 'user/login';
                }
            },
            error: function (request, status, error) {
                window.location = 'user/login';
                console.log(request.responseText);
               //alert(request.responseText);
            }
        });
    }


    function showProductAdded(productRequest) {
        if (productRequest != null) {
            $('#img_product').attr('src', BASE_URL + '/' + productRequest.product1_file);
            $('#div_product_description').html(productRequest.product_description);
            $('#div_product_title').html(productRequest.product1_title);
            $('#sp_product_price').text(productRequest.price);
            $('#sp_product_volume').text(productRequest.volumn);
        }
        $('#modal_add_to_cart').modal('show');
    }

</script>

@endpush