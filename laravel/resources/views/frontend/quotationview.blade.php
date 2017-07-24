@extends('layouts.main')
@section('page_heading',trans('message.menu_order_list'))
@section('page_heading_image','<i class="glyphicon glyphicon-apple"></i>')
@section('content')
    {{--@if($user->id == $quotation->seller_id)
        @include('shared.usermenu', array('setActive'=>'quote'))
    @else--}}
    @include('shared.usermenu', array('setActive'=>'quotation'))
    {{--@endif--}}

    <div class="col-sm-12">
        <div class="row">
            <div class="panel panel-default" style="margin-top: 30px">
                <div class="panel-heading">
                    <h4>{{ trans('messages.quotation')}}</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th width="180">{{ trans('messages.quotation_date') }}</th>

                                    <th>{{ trans('messages.i_buy') }}</th>

                                    <th>{{ trans('messages.i_sale') }}</th>

                                    @if($quotation->user->users_mobilephone !='')
                                        <th>{{ trans('validation.attributes.users_mobilephone') }}</th>
                                    @endif
                                    @if($quotation->user->users_phone !='')
                                        <th>{{ trans('validation.attributes.users_phone') }}</th>
                                    @endif
                                    @if($quotation->user->email !='')
                                        <th>{{ trans('validation.attributes.email') }}</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{  \App\Helpers\DateFuncs::mysqlToThaiDate($quotation->updated_at) }}</td>

                                    <td>{{  $quotation->buyer_firstname . " " .$quotation->buyer_lastname }}</td>

                                    <td>{{  $quotation->users_firstname_th . " " .$quotation->users_lastname_th }}</td>

                                    @if($quotation->user->users_mobilephone !='')
                                        <td>{{ $quotation->user->users_mobilephone }}</td>
                                    @endif
                                    @if($quotation->user->users_phone !='')
                                        <td>{{ $quotation->user->users_phone }}</td>
                                    @endif
                                    @if($quotation->user->email !='')
                                        <td>{{ $quotation->user->email }}</td>
                                    @endif
                                </tr>
                                </tbody>
                            </table>
                            <br>
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>{{ trans('validation.attributes.users_addressname') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $quotation->user->users_addressname . " " . $quotation->user->users_district . " " . $quotation->user->users_city . " " . $quotation->user->users_province . " " . $quotation->user->users_postcode }}</td>
                                </tr>
                                </tbody>
                            </table>

                            <br>
                            <strong>สินค้า</strong>
                            <input type="hidden" id="price-by-product" value="{{$quotation->price}}">
                            <input type="hidden" id="price-total" value="{{$quotation->min_order * $quotation->price}}">
                            <input type="hidden" id="min_order" value="{{$quotation->min_order}}">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>{{ trans('validation.attributes.product_name_th') }}</th>
                                    <th>{{ trans('validation.attributes.product_title') }}</th>
                                    <th>จำนวน</th>
                                    <th>{{ trans('validation.attributes.price') }}</th>
                                    {{--<th>{{ trans('validation.attributes.discount') }}</th>--}}
                                    <th>รวม</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{  $quotation->product_name_th }}</td>
                                    <td>{{  $quotation->product_title }}</td>
                                    <td style="width: 115px;">
                                        @if($user->id != $quotation->seller_id)
                                            <input type="number" class="form-control" id="qty"
                                                   value="{{$quotation->quantity}}" min="{{$quotation->quantity}}">
                                        @else
                                            {{$quotation->quantity}}
                                        @endif
                                    </td>
                                    <td>
                                        <strong>
                                            {{  $quotation->price. " " .trans('messages.baht')." / ".$quotation->units }}
                                        </strong>
                                    </td>
                                    {{--<td>{{  $quotation->discount }}</td>--}}
                                    <td><span id="show_price_total">{{$quotation->min_order * $quotation->price}}</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            @if(!empty($quotation->remark))
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>{{ trans('messages.remark') }}</th>
                                        {{--<th>{{ trans('validation.attributes.discount') }}</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{  $quotation->remark }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            @endif
                            @if($user->id != $quotation->seller_id)
                                <div class="panel panel-default" style="margin-top: 30px">
                                    <div class="panel-heading">
                                        <h4>{{ trans('messages.title_delivery_product') }}</h4>
                                    </div>
                                    <div class="panel-body">
                                        @include('frontend.quotation.address_delivery')
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <strong>รูปภาพสินค้า</strong>
                            <br>
                            <br>
                            <img style="width: 100%; overflow: hidden; min-height: 200px;"
                                 src="{{url($quotation->product1_file)}}">
                        </div>
                    </div>
                    @if($user->id != $quotation->seller_id)
                        <div class="row">
                            <div class="col-md-2 col-md-offset-5">
                                <button type="button" class="btn btn-primary"
                                        onclick="addToCart('{{$quotation->product_request_id}}','{{$quotation->seller_id}}','{{$quotation->price}}','{{$quotation->min_order}}')">
                                    <i class="fa fa-shopping-cart"></i>
                                    สั่งซื้อสินค้า
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="alertModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">ข้อความ</h4>
                </div>
                <div class="modal-body">
                    <p style="color: red;">{{ trans('messages.ms_qty_min_order') }}</p>
                    <p style="color: orange;">
                        *** {{ trans('messages.text_min_order') }} : <span
                                id="qty_min_order"></span> {{$quotation->units}}
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        {{trans('messages.text_close')}}
                    </button>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('scripts')
<script>

    $(document).ready(function () {

    });
    function hsHtml() {
        var delivery_chanel = $('#delivery_chanel option:selected').val();
        var address_delivery = $('textarea #address_delivery').val();
        var hd_address_delivery = $('#hd_address_delivery').val();

        if (delivery_chanel == 'รับเอง') {
            $('#address_hidden').empty();
        } else {
            var html_address = '<strong> * ระบุสถานที่จัดส่ง :</strong><textarea name="address_delivery" id="address_delivery" class="form-control" style="margin-bottom: 5px;">' + hd_address_delivery + '</textarea><span id="mss_address_delivery" class="alert-danger"></span>';
            $('#address_hidden').html(html_address);
        }
        return false;
    }

    function addToCart(productRequestId, userId, unit_price, min_order) {

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var targetUrl = '{{url('/user/quotation/checkout')}}';
        var priceTotal = $('#price-total').val();
        var qty = $('#qty').val();
        //alert(CSRF_TOKEN); return false;
        var delivery_chanel = $('#delivery_chanel option:selected').val();
        var address_delivery = $('textarea#address_delivery').val();
        var address_delivery_new = '';
        if (delivery_chanel == 'จัดส่งตามที่อยู่') {
            if (!address_delivery) {
                $('#address_delivery').focus();
                $('#mss_address_delivery').html('<?php echo trans('messages.ms_validate_address_delivery')?>');
                return false;
            }
            address_delivery_new = address_delivery;
        }

        $.ajax({
            headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
            type: 'POST',
            url: targetUrl,
            data: {
                _token: CSRF_TOKEN,
                product_request_id: productRequestId,
                user_id: userId,
                unit_price: unit_price,
                min_order: min_order,
                price_total: priceTotal,
                qty: qty,
                delivery_chanel: delivery_chanel,
                address_delivery: address_delivery_new
            },
            dataType: 'json',
            success: function (response) {
                if (response.R == 'Y') {
//                    showProductAdded(response.product_request);
                    window.location = '<?php echo url('user/order')?>';
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
            window.location.href = "{{url('user/shoppingcart')}}";
        }
    }

    $('#qty').on('input', function (e) {
        var qty = parseInt($(this).val());
        var min_order = parseInt($('#min_order').val());
        var price_by_product = parseInt($('#price-by-product').val());
        var price_total = parseInt($('#price-total').val());
        if (qty < min_order) {
            $('#qty_min_order').html(min_order);
            $('#alertModal').modal('show');
            $('#qty').val(min_order).change();
            return false
        }
        var new_price_total = qty * price_by_product;
        $('#price-total').val(new_price_total);
        $('#show_price_total').html(new_price_total);
        return false
    });

</script>
@endpush