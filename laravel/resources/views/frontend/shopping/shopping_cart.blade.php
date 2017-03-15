@extends('layouts.main')
@section('content')

    <div style="background-color: white">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-10 col-md-offset-1">
                    <h2>ตะกร้าของฉัน</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-10 col-md-offset-1">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th >Product</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Total</th>
                            <th> </th>
                        </tr>
                        </thead>
                        <tbody>

                        @if(isset($carts))

                            @foreach($carts as $cart)

                                <tr>
                                    <td class="col-sm-7 col-md-6">
                                        <div class="media">
                                            <a class="thumbnail pull-left" href="#" style="margin-right: 10px">
                                                <img class="media-object" src="{{url($cart['iwantto']['product1_file'])}}" style="width: 60px; height: 60px;">
                                            </a>
                                            <div class="media-body">
                                                <h4 class="media-heading"><a href="#">{{$cart['iwantto']['product_title']}}</a></h4>
                                                <h5 class="media-heading"> <a href="#"></a></h5>
                                                <span>Status: </span><span class="text-success"><strong>In Stock</strong></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="col-sm-2 col-md-2" >
                                        <div class="input-append text-left">
                                            <a href="#" class="btn btn-default minus"> <i class="fa fa-minus"></i></a>
                                            <input class="text-center product_quantity" style="max-width: 40px; height: 35px"  value="{{$cart["item"]}}" id="appendedInputButtons" size="16" type="text">
                                            <a href="#" class="btn btn-default plus"><i class="fa fa-plus"></i></a>
                                        </div>
                                    </td>
                                    <td class="col-sm-1 col-md-1 text-center"><strong> <span class="product_price">{{$cart['iwantto']['price']}}</span></strong></td>
                                    <td class="col-sm-1 col-md-1 text-center"><strong><span class="total">{{ number_format (intval($cart["item"])*floatval($cart['iwantto']['price']), 2 ) }}</span></strong></td>
                                    <td class="col-sm-1 col-md-1">
                                        <button id="btn_remove" type="button" class="btn btn-danger delete-button">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                            @endforeach
                        @endif
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td><h5>Subtotal</h5></td>
                            <td class="text-right"><h5><strong>$24.59</strong></h5></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td><h5>Estimated shipping</h5></td>
                            <td class="text-right"><h5><strong>$6.94</strong></h5></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td><h3>Total</h3></td>
                            <td class="text-right"><h3><strong>$31.53</strong></h3></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>
                                <button type="button" class="btn btn-default">
                                    <span class="glyphicon glyphicon-shopping-cart"></span> Continue Shopping
                                </button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-success">
                                    Checkout <span class="glyphicon glyphicon-play"></span>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop

@push('scripts')
<script>
    var BASE_URL = '<?php echo url('/')?>';

    $(document).ready(function () {

        //remove row
        $('table').on('click','.delete-button',function(){
            $(this).parents('tr').remove();
        });

        eventAddOrMinusQuantity();

        calculateTotal();

    });
    
    
    function calculateTotal() {
        $('.product_quantity').change(function(){
            var $row = $(this).closest("tr");
            var qty = parseInt($row.find('.product_quantity').val());
            var price = parseFloat($.trim($row.find(".product_price").text()));
            var total = qty * price;
            $row.find('.total').text(total.toFixed(2));
//            console.log(qty)
//            console.log(price)
        })
    }
    
    function eventAddOrMinusQuantity() {
        $('.plus').click(function(){
            var $row = $(this).closest("tr");
            var qty = $row.find('.product_quantity').val();
            if(qty != ''){
                qty = parseInt(qty)+1;
            }else {
                qty = 1;
            }
            $row.find('.product_quantity').val(qty);
        });

        $('.minus').click(function(){
            alert('minus');
        });
    }
    
    function handlerProductQuantity() {
        
    }

//    jQuery('.delbtn').on('click', function() {
    //        var $row = jQuery(this).closest('tr');
    //        var $columns = $row.find('td');
    //
    //        $columns.addClass('row-highlight');
    //        var values = "";
    //
    //        jQuery.each($columns, function(i, item) {
    //            values = values + 'td' + (i + 1) + ':' + item.innerHTML + '<br/>';
    //            alert(values);
    //        });
    //        console.log(values);
    //    });

</script>
@endpush