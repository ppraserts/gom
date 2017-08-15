<?php
    $user = auth()->guard('user')->user();
?>
@extends('layouts.main')
@section('content')
    @include('shared.resultsearch')
    <br/>
    <h3>{{ trans('messages.i_want_to_sale') }}</h3>
    @if($itemssale!=null && count((array)$itemssale)>0)
        <div class="row">
            <?php
            $arr = (array)$itemssale;
            foreach(array_chunk($arr, 3, true) as $div_item)
            {
            foreach ($div_item as $col_md_4_items)
            {
            $col_md_4_item = (array)$col_md_4_items;

            $product_name = $col_md_4_item['product_name_th'];

            $imageName_temp = iconv('UTF-8', 'tis620', $col_md_4_item['product1_file']);
            if (!file_exists($imageName_temp)) {
                $col_md_4_item['product1_file'] = '/images/default.jpg';
            }
            ?>
            <div class="col-md-3">
                <div class="col-item">
                    <div class="photo crop-height">
                        <img src="{{ url($col_md_4_item['product1_file']) }}" class="scale" alt="a">
                    </div>
                    <div class="info">
                        <div class="row">
                            <div class="price col-md-12">
                                {{--@if($col_md_4_item['product_stock'] < 1)--}}
                                    {{--<strong class="label label-danger {{$col_md_4_item['product_stock'] > 0 ? 'invisible' : ''}}">สินค้าหมด</strong>--}}
                                {{--@endif--}}
                                <h4 title="{{ $product_name }}"
                                    style="white-space: nowrap; line-height:2em; margin-top: 2px;     margin-bottom: 5px; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $product_name }}
                                </h4>
                                <?php
                                $avg_score = 0;
                                if (!empty($col_md_4_item['avg_score'])) {
                                    $avg_score = round($col_md_4_item['avg_score']);
                                }
                                ?>

                                <div class="row">
                                    <div class="score-star col-md-8">
                                        @if($avg_score == 1)
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                        @elseif($avg_score == 2)
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                        @elseif($avg_score == 3)
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                        @elseif($avg_score == 4)
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                        @elseif($avg_score == 5)
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        @elseif($avg_score == 0)
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                        @endif

                                    </div>
                                    <div class="col-md-4">
                                    <strong class="label label-danger {{$col_md_4_item['product_stock'] > 0 ? 'invisible' : ''}}">สินค้าหมด</strong>
                                    </div>
                                </div>

                                <div style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis; padding-top: 5px; padding-bottom: 5px;">
                                    <span class="glyphicon glyphicon-tag"></span>
                                    <i title="{{ $product_name }}">
                                        {{$col_md_4_item['product_title']}}
                                    </i><br/>
                                </div>
                                <div style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis; padding-bottom: 5px;">
                                    <span class="glyphicon glyphicon-map-marker"></span>
                                    {{$col_md_4_item['province']}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis; padding-bottom: 5px;">
                                    <span class="hidden-sm">  {{ $col_md_4_item['is_showprice']? trans('messages.unit_price'). " ".floatval($col_md_4_item['price']). trans('messages.baht')." / ". $col_md_4_item['units'] : trans('messages.product_no_price') }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">

                                <a href="{{ url('productview/'.$col_md_4_item['id']) }}"
                                   class="btn btn-info btn-sm">{{ trans('messages.button_moredetail')}}</a>
                            </div>

                            @if($col_md_4_item['productstatus'] == 'open' && ($user==null || ($user!=null && $user->id != $col_md_4_item['product_user_id'])) && ($user==null || ($user!=null && $user->iwanttobuy == 'buy')))
                                @if(($col_md_4_item['selling_type'] == 'retail' or $col_md_4_item['selling_type'] == 'all') && $col_md_4_item['product_stock'] > 0)
                                    <div class="col-md-3">
                                        <a href="#"
                                           onclick="addToCart('{{$col_md_4_item['id']}}' , '{{$col_md_4_item['users_id']}}' , '{{$col_md_4_item['price']}}' , '{{$col_md_4_item['min_order']}}')"
                                           class="btn btn-primary btn-sm">
                                            <i class="fa fa-shopping-cart"></i>
                                        </a>
                                    </div>
                                @endif
                            @endif
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
    @if($itemsbuy!=null && count((array)$itemsbuy)>0)
        <div class="row">
            <?php
            $arr = (array)$itemsbuy;
            foreach(array_chunk($arr, 3, true) as $div_item){
            foreach ($div_item as $col_md_4_items){
            $col_md_4_item = (array)$col_md_4_items;
            ?>
            <div class="col-md-3" title="{{ \App\Helpers\DateFuncs::mysqlToThaiDate($col_md_4_item['created_at']) }}">
                <div class="col-item">
                    <div class="info">
                        <div class="row">
                            <div class="price col-md-12">
                                <h4>
                                    @if(!empty($col_md_4_item['product_name_th']))
                                        {{mb_strimwidth($col_md_4_item['product_name_th'], 0, 25, '...', 'UTF-8')}}
                                    @else
                                        -
                                    @endif
                                </h4>
                                จำนวน
                                : {{ floatval($col_md_4_item['volumnrange_start']) }} {{ $col_md_4_item['units'] }}
                                <br/>
                                <span class="hidden-sm">
                                    {{trans('messages.price')}}
                                    : {{ floatval($col_md_4_item['pricerange_start']) }}
                                    - {{ floatval($col_md_4_item['pricerange_end']) }} {{trans('messages.baht')}}
                                </span>
                                <br/>
                                <span class="glyphicon glyphicon-map-marker"></span>
                                @if(!empty($col_md_4_item['province']))
                                    {{mb_strimwidth($col_md_4_item['province'], 0, 33, '...', 'UTF-8')}}
                                @else
                                    {{trans('messages.allprovince')}}
                                @endif

                                <br/><br/>
                            </div>

                        </div>
                        <div class="clear-left">
                            <a href="{{ url('productview/'.$col_md_4_item['id']) }}" class="btn btn-info btn-sm">
                                <i class="fa fa-list"></i> {{ trans('messages.button_moredetail')}}
                            </a>
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title text-success" style="color: #00cc66">
                            สินค้าได้ถูกเพิ่มเข้าไปยังตะกร้าสินค้าของคุณ
                        </h4>
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
                           class="btn btn-success"><i class="fa fa-shopping-cart"></i> ตะกร้าสินค้า</a>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->

@stop

@push('scripts')
<link rel="stylesheet" href="{{url('css/star.css')}}">
<script>

    var BASE_URL = '<?php echo url('/')?>';

    $(document).ready(function () {
        $('#modal_add_to_cart').on('hidden.bs.modal', function () {
            location.reload();
        });
    });

    function addToCart(productRequestId, userId, unit_price, min_order) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var targetUrl = BASE_URL + '/user/shoppingcart/addToCart';
        $.ajax({
            type: 'POST',
            url: targetUrl,
            data: {
                _token: CSRF_TOKEN,
                product_request_id: productRequestId,
                user_id: userId,
                unit_price: unit_price,
                min_order: min_order
            },
            dataType: 'json',
            success: function (response) {
                if (response.status == 'success') {
                    showProductAdded(response.product_request);
                } else {
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
            $('#units').html(productRequest.units);
        }
        $('#modal_add_to_cart').modal('show');
    }

</script>

@endpush