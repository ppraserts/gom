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
                                            <img class="media-object" src="{{url($cart['iwantto']['product1_file'])}}"
                                                 style="width: 60px; height: 60px;">
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
                                        <a href="#" class="btn btn-default"> <i class="fa fa-minus"></i></a>
                                        <input class="text-center" style="max-width: 40px; height: 35px"  value="{{$cart["item"]}}" id="appendedInputButtons" size="16" type="text">
                                        <a href="#" class="btn btn-default"><i class="fa fa-plus"></i></a>
                                    </div>
                                </td>
                                <td class="col-sm-1 col-md-1 text-center"><strong> <span id="">{{$cart['iwantto']['price']}}</span></strong></td>
                                <td class="col-sm-1 col-md-1 text-center"><strong>$14.61</strong></td>
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
    })

    jQuery('.delbtn').on('click', function() {
        var $row = jQuery(this).closest('tr');
        var $columns = $row.find('td');

        $columns.addClass('row-highlight');
        var values = "";

        jQuery.each($columns, function(i, item) {
            values = values + 'td' + (i + 1) + ':' + item.innerHTML + '<br/>';
            alert(values);
        });
        console.log(values);
    });

</script>
@endpush