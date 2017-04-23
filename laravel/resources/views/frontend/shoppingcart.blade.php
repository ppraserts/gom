@extends('layouts.main')
@section('content')

    <form id="form_shopping_cart">
        <div style="background-color: white">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-10 col-md-offset-1">
                        <h2>ตะกร้าของฉัน</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-10 col-md-offset-1">
                        <table id="table_cart" class="table table-hover">
                            <thead>
                            <tr>
                                <th>Product</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Total</th>
                                <th> </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($carts))
                                @foreach($carts as $cart)
                                    <tr class="data">
                                        <td class="col-sm-7 col-md-6">
                                            <div class="media">
                                                <a class=" pull-left" href="#" style="margin-right: 10px">
                                                    <img class="media-object" src="{{url($cart['product_request']['product1_file'])}}"
                                                         style="width: 60px; height: 60px;">
                                                </a>
                                                <div class="media-body">
                                                    <h4 class="media-heading"><a href="#">{{$cart['product_request']['product_title']}}</a></h4>
                                                    <h5 class="media-heading"><a href="#"></a></h5>
                                                    <span class="text-success">
                                                        <strong><span class="glyphicon glyphicon-map-marker"></span>
                                                            {{ $cart['product_request']['city'] }} {{ $cart['product_request']['province'] }}</strong>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-sm-2 col-md-2">
                                            <div class="input-append text-left">
                                                <a href="#" class="btn btn-default minus"> <i class="fa fa-minus"></i></a>
                                                <input class="text-center product_quantity" style="max-width: 40px; height: 33px" value="{{$cart["qty"]}}"
                                                       id="appendedInputButtons" size="16" type="text">
                                                <a href="#" class="btn btn-default plus"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </td>
                                        <td class="col-sm-1 col-md-1 text-center"><strong>
                                                <span class="product_price">{{$cart['product_request']['price']}}</span>
                                            </strong></td>
                                        <td class="col-sm-1 col-md-1 text-center">
                                            <strong><span
                                                        class="total">{{ number_format (intval($cart["qty"])*floatval($cart['product_request']['price']), 2 ) }}</span></strong>
                                        </td>
                                        <td class="col-sm-1 col-md-1">
                                            <div class="text-center">
                                                <button id="btn_remove" type="button" class="btn btn-danger delete-button ">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td style="display:none;"><input type="hidden" value="{{$cart['product_request']['id']}}"></td>
                                        <td style="display:none;"><input type="hidden" value="{{$cart['product_request']['products_id']}}"></td>
                                    </tr>
                                @endforeach
                            @endif
                            {{--<tr>--}}
                            {{--<td>&nbsp;</td>--}}
                            {{--<td>&nbsp;</td>--}}
                            {{--<td>&nbsp;</td>--}}
                            {{--<td><h5>Subtotal</h5></td>--}}
                            {{--<td class="text-right"><h5><strong>$24.59</strong></h5></td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td>&nbsp;</td>--}}
                            {{--<td>&nbsp;</td>--}}
                            {{--<td>&nbsp;</td>--}}
                            {{--<td><h5>Estimated shipping</h5></td>--}}
                            {{--<td class="text-right"><h5><strong>$6.94</strong></h5></td>--}}
                            {{--</tr>--}}
                            <tr>
                                <td>&nbsp;</td>
                                <td colspan="2"><h3>มูลค่าสินค้า</h3></td>
                                <td colspan="2" class="text-right"><span id="order_total"></span></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>
                                    <button onclick="window.history.back()" type="button" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-shopping-cart"></span> เลือกซื้อสินค้าต่อ
                                    </button>
                                </td>
                                <td>
                                    <button id="btn_save" type="submit" class="btn btn-success"><i class="fa fa-sticky-note-o"></i> สั่งซื้อสินค้า </span>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>

@stop

@push('scripts')
<script>
    var BASE_URL = '<?php echo url('/')?>';

    $(document).ready(function () {

        handleRemoveCart();

        handlePlusOrMinusQuantity();

        handleProductQuantity();

        calculateOrderTotal();

        checkout();
    });

    function handleRemoveCart() {
        //remove row
        $('table').on('click', '.delete-button', function () {
            $(this).parents('tr').remove();
            calculateOrderTotal();
        });
    }

    function handlePlusOrMinusQuantity() {
        $('.plus').click(function () {
            var $row = $(this).closest("tr");
            var qty = $row.find('.product_quantity').val();
            if (qty != '') {
                qty = parseInt(qty) + 1;
            } else {
                qty = 1;
            }
            $row.find('.product_quantity').val(qty);
            calculateTotalEachRow($row);
        });

        $('.minus').click(function () {
            var $row = $(this).closest("tr");
            var qty = $row.find('.product_quantity').val();
            if (qty != '') {
                qty = parseInt(qty) - 1;
                if (qty > 0) {
                    $row.find('.product_quantity').val(qty);
                }
            }
            calculateTotalEachRow($row);
        });
    }

    function handleProductQuantity() {
        $('.product_quantity').change(function () {
            var $row = $(this).closest("tr");
            calculateTotalEachRow($row);
        })
    }

    function calculateTotalEachRow($row) {
        if ($row != null) {
            var qty = parseInt($row.find('.product_quantity').val());
            var price = parseFloat($.trim($row.find(".product_price").text()));
            var total = qty * price;
            $row.find('.total').text(total.toFixed(2));
            calculateOrderTotal();
        }
    }

    function calculateOrderTotal() {
        var orderTotal = 0;
        $('.total').each(function () {
            orderTotal += parseFloat($(this).text());
        });

        $('#order_total').html('<h3><strong>' + orderTotal.toFixed(2) + ' บาท </h3></strong');
    }

    function checkout() {
        $('#form_shopping_cart').on('submit', function (e) {
            e.preventDefault();

            var cart_items = [];
            $('#table_cart').find('tbody tr.data').each(function (i, el) {
                var $tds = $(this).find('td');
                var quantity = $tds.eq(1).find('input').val();
                var unit_price = $tds.eq(2).text().trim();
                var total = $tds.eq(3).text().trim();
                var id = $tds.eq(5).find('input').val();
                var product_id = $tds.eq(6).find('input').val();
                var cart_item = {
                    id: id,
                    unit_price: unit_price,
                    quantity: quantity,
                    total: total,
                    product_id: product_id
                };
                // add to list
                cart_items.push(cart_item);
            });

            var totalOrder = 0;
            $('.total').each(function () {
                totalOrder += parseFloat($(this).text());
            });

            var targetUrl = BASE_URL + '/user/shoppingcart/checkout';
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            console.log(cart_items);
            console.log(targetUrl);

            $.ajax({
                type: 'POST',
                url: targetUrl,
                data: {_token: CSRF_TOKEN, cart_items: cart_items, total_amount: totalOrder},
                dataType: 'json',
                success: function (response) {
                    if (response.status == 'success') {
                        bootbox.alert({
                            message: "บันทึกข้อมูลสำเร็จ",
                            size: 'small',
                            callback: function () {
                                window.location.href = '{{url("result")}}';
                            }
                        }).find('.modal-content').css({
                            'margin-top': function () {
                                var w = $(window).height();
                                var b = $(".modal-dialog").height();
                                var h = (w - b) / 2;
                                return h + "px";
                            }
                        });
                    } else {
                        bootbox.alert({
                            message: "พบข้อผิดพลาดในการบันทึกข้อมูล",
                            size: 'small'
                        }).find('.modal-content').css({
                            'margin-top': function () {
                                var w = $(window).height();
                                var b = $(".modal-dialog").height();
                                var h = (w - b) / 2;
                                return h + "px";
                            }
                        });
                    }
                },
                error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
        });
    }

</script>
@endpush