<?php
$pagetitle = trans('message.menu_order_list');
?>
@extends('layouts.main')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="glyphicon glyphicon-apple"></i>')
@section('content')
    <?php
    $actionSetActive ='';
    if(!empty(Session::get('orderType')) and Session::get('orderType') == 'sale'){
       $actionSetActive ='shoporder';
    }elseif(!empty(Session::get('orderType')) and Session::get('orderType') == 'buy'){
        $actionSetActive ='order';
    }
    ?>
    @include('shared.usermenu', array('setActive'=>$actionSetActive))
    <div class="col-sm-12">
        <div class="row">
            @if(!empty(Session::get('orderType')) and Session::get('orderType') == 'sale')
                <h2>{{ trans('messages.order_detail') }}</h2>
            @elseif(!empty(Session::get('orderType')) and Session::get('orderType') == 'buy')
                <h2>{{ trans('messages.order_detail') }}</h2>
            @endif
            <div class="col-md-4">
                <div class="row">
                    <?php
                      $statusHistory_n = count($order->statusHistory);
                    ?>
                    <h3>{{ trans('messages.order_id') . " : " . $order->id }}</h3>
                    <p><b>{{ trans('messages.order_date') }} : </b>{{$order->order_date}}</p>
                    <p><b>{{ trans('messages.order_status') }} : </b>{{$order->statusHistory[$statusHistory_n-1]['status_text']}}</p>
                    <p><b>{{ trans('messages.order_type') }} : </b>{{ $order->order_type== 'retail'? trans('messages.retail'): trans('messages.wholesale')}}</p>
                    <h4><b>{{ trans('messages.total_order') }}
                            : </b>{{$order->total_amount}}  {{trans('messages.baht')}}
                    </h4>
                </div>
            </div>

            <div class="col-md-4">
                <div class="row">
                    <h3>{{ trans('messages.i_buy') }}</h3>

                    <p>
                        <b>{{ trans('validation.attributes.name') }}
                            : </b>{{$order->buyer->users_firstname_th. " ". $order->buyer->users_lastname_th}}
                    </p>
                    @if(isset($order->buyer->user->users_mobilephone))<p>
                        <b>{{ trans('validation.attributes.users_mobilephone') }}
                            : </b>{{ $order->buyer->user->users_mobilephone }}</p>@endif
                    @if(isset($order->buyer->user->users_phone))<p><b>{{ trans('validation.attributes.users_phone') }}
                            : </b>{{ $order->buyer->user->users_phone }}</p>@endif
                    @if(isset($order->buyer->user->email))<p><b>{{ trans('validation.attributes.email') }}
                            : </b>{{ $order->buyer->user->email }}</p>@endif
                    <p><b>{{ trans('validation.attributes.users_addressname') }}
                            : </b>{{ $order->buyer->users_addressname . " " . $order->buyer->users_district . " " . $order->buyer->users_city . " " . $order->buyer->users_province . " " . $order->buyer->users_postcode }}
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="row">
                    <h3>{{ trans('messages.i_sale') }}</h3>

                    <p><b>{{ trans('validation.attributes.name') }}
                            : </b>{{$order->user->users_firstname_th. " ". $order->user->users_lastname_th}}</p>
                    @if(isset($order->user->users_mobilephone))<p>
                        <b>{{ trans('validation.attributes.users_mobilephone') }}
                            : </b>{{ $order->user->users_mobilephone }}</p>@endif
                    @if(isset($order->user->users_phone))<p><b>{{ trans('validation.attributes.users_phone') }}
                            : </b>{{ $order->user->users_phone }}</p>@endif
                    @if(isset($order->user->email))<p><b>{{ trans('validation.attributes.email') }}
                            : </b>{{ $order->user->email }}</p>@endif
                    <p><b>{{ trans('validation.attributes.users_addressname') }}
                            : </b>{{ $order->user->users_addressname . " " . $order->user->users_district . " " . $order->user->users_city . " " . $order->user->users_province . " " . $order->user->users_postcode }}
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <h3>{{trans('messages.title_receiving_address')}}</h3>
                        <b>{{trans('messages.text_delivery_channel')}} : </b>{{$order->delivery_chanel}}
                    @if(!empty($order->address_delivery))
                        <br/><b>{{trans('messages.text_address_delivery')}} : </b>{{$order->address_delivery}}
                    @endif
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <h3>{{ trans('messages.product_list') }}</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th width="70px" style="text-align:center;">{{ trans('messages.order_id') }}</th>
                                <th>{{ trans('messages.shop_product') }}</th>
                                <th width="100px" style="text-align:center;">{{ trans('messages.quantity') }}</th>
                                <th width="110px" style="text-align:center;">{{ trans('validation.attributes.price') }}</th>
                                <th width="110px" style="text-align:center;">{{ trans('messages.total_order') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0 ?>
                            @foreach ($order->orderItems as $key => $item)
                                <tr>
                                    <td style="text-align:center;">{{ ++$i }}</td>
                                    <td>
                                        {{ $item->product_name_th }}
                                    </td>
                                    <td style="text-align:center;">{{ $item->quantity ." ". $item->units }}</td>
                                    <td style="text-align:center;">{{ $item->unit_price . trans('messages.baht') }}</td>
                                    <td style="text-align:center;">{{ $item->total . trans('messages.baht') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <h3>{{ trans('messages.order_status_history') }}</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th style="text-align:center;">{{ trans('validation.attributes.created_at') }}</th>
                                <th style="text-align:center;">{{ trans('messages.order_status') }}</th>
                                <th style="text-align:center;">บันทึกเพิ่มเติม</th>
                                <th style="text-align:center;">ไฟล์</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0; $status_id = ''; ?>
                            @foreach ($order->statusHistory as $key => $item)
                                <tr>
                                    <td style="text-align:center;">{{ \App\Helpers\DateFuncs::mysqlToThaiDate($item->created_at)}}</td>
                                    <td style="text-align:center;">{{ $item->status_text}}</td>
                                    <td style="text-align:left; max-width: 400px;">
                                        @if($item->status_id == 4)
                                            ช่องทางการจัดส่ง : {{$item->delivery_chanel}}<br/>
                                            วันที่จัดส่ง :{{$item->order_date}} <br/>
                                            {!! $item->note !!}
                                        @endif
                                        <?php
                                        if($item->status_id == 6){
                                            $arr = explode("\n",$item->note);
                                            if (sizeof($arr)) {
                                                $countArr = count($arr);
                                                $count_i = 1;
                                                $br ='';
                                                foreach ($arr as $ele) {
                                                    $ele = trim($ele);
                                                    if($count_i == $countArr){
                                                        echo $ele;
                                                    }else{
                                                        echo $ele.'<br/>';
                                                    }
                                                    $count_i++;
                                                }
                                            }
                                        }else if($item->status_id !=4 and $item->status_id != 6){
                                        ?>
                                        {!! $item->note !!}
                                        <?php }?>
                                    </td>
                                    <td style="text-align:left;">
                                        @if(!empty($item->image_payment_url))
                                            <a href="{{url('upload/payments/'.$item->image_payment_url)}}" target="_blank">
                                                ดาวน์โหลด
                                            </a>
                                        @else
                                            -
                                        @endif

                                    </td>
                                </tr>
                                <?php $status_id = $item->status_id; ?>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php
            $user = auth()->guard('user')->user();
            $userId = $user->id;
            ?>

            @if($order->buyer->id == $userId and $status_id == 7)
                @include('frontend.order_element.payment')
            @endif
            @if($order->userId == $userId)
                @if($status_id == 1)
                    @include('frontend.order_element.confirm_sale')
                @endif
                @if($status_id == 8)
                    @include('frontend.order_element.delivery')
                @endif
            @endif
            @if($status_id == 4 || $status_id == 5)
            @else
                @if($status_id <= 2)
                    @include('frontend.order_element.canceled')
                @endif
            @endif
        </div>

    </div>
@endsection
@push('scripts')
<script>
    $("#payment_channel").on("change", function () {
        var payment_channel = $("#payment_channel option:selected").val();
        if(payment_channel == 'บัญชีธนาคาร'){
            payment_channel = 1;
            $.get("<?php echo url('/user/orderdetail/html-payment-channel')?>/"+ payment_channel, function (data) {
                if (data.r == 'Y') {
                    if (data.data_html != '') {
//                        $("#html_payment_channel").html(data.data_html);
                        $('#note').val(data.data_html);
                    } else {
                        //$("#html_payment_channel").html('Error....');
                    }
                } else {
                    //$("#html_payment_channel").html('');
                }
            });
        }else{
            $("#note").val(payment_channel);
        }
    });

    $(document).ready(function(){
        $("#form-image_payment").submit(function (e) {
            var payment_file =  $('#payment_image').val();
            if (payment_file == '') {
                $('#payment_image').val('');
                $('#ms_payment_image').css({
                    'color': '#a94442',
                    'background-color': 'rgba(255, 235, 59, 0.18)',
                    'font-size': '15px'
                });
                $("#ms_payment_image").html("<?php echo trans('validation.attributes.message_validate_type_payment')?>");
                $('#payment_image').focus;
                return false;
            }
        })
    });

    $("#payment_image").on("change", function () {
        var ext = $('#payment_image').val().split('.').pop().toLowerCase();
        $("#ms_payment_image").empty();
        if($.inArray(ext, ['gif','png','jpg','jpeg','pdf','PDF','JPG']) == -1) {

            $('#payment_image').val('');
            $('#ms_payment_image').css({
                'color': '#a94442',
                'background-color': 'rgba(255, 235, 59, 0.18)',
                'font-size': '15px'
            });
            $("#ms_payment_image").html("<?php echo trans('validation.attributes.message_validate_type_payment')?>");
            $('#payment_image').focus();
            return false;
        }
    });

    $("#delivery_image").on("change", function () {
        var ext = $('#delivery_image').val().split('.').pop().toLowerCase();
        $("#ms_delivery_image").empty();
        if($.inArray(ext, ['gif','png','jpg','jpeg','pdf','PDF','JPG']) == -1) {

            $('#delivery_image').val('');
            $("#ms_delivery_image").html("<?php echo trans('validation.attributes.message_validate_delivery_image')?>");
            $('#delivery_image').focus();
            return false;
        }
    });

    $('#pick_start_date').datepicker({
        format: 'yyyy-mm-dd',
        language: 'th-th',
        autoclose: true,
        toggleActive: false,
        todayHighlight: false,
        todayBtn: false,
        startView: 2,
        maxViewMode: 2
    });
    $('#pick_end_date').datepicker({
        format: 'yyyy-mm-dd',
        language: 'th-th',
        autoclose: true,
        toggleActive: false,
        todayHighlight: false,
        todayBtn: false,
        startView: 2,
        maxViewMode: 2
    });

    initialViews();

    function initialViews() {

        //Selling Period
        var selling_period = '{{$item->selling_period}}';
        if (selling_period == 'year') {
            $('.div_selling_period_date').hide();
        } else {
            $("input[type=radio][name=selling_period]:first").attr('checked', true);
        }
    }

    $(document).ready(function() {
        $("#delivery_form").submit(function (e) {
            var delivery_chanel = $("#delivery_chanel").val();
            var order_date = $("#order_date").val();
            var delivery_image = $('#delivery_image').val();
            $("#mss_delivery_chanel").empty();
            if (delivery_chanel == '') {
                $("#delivery_chanel").focus();
                $("#mss_delivery_chanel").html("<?php echo trans('messages.message_validate_delivery_chanel')?>");
                return false;
            }
            $("#mss_order_date").empty();
            if (order_date == '') {
                $("#order_date").focus();
                $("#mss_order_date").html("<?php echo trans('messages.message_validate_delivery_date')?>");
                return false;
            }
            if (delivery_image == '') {
                $('#delivery_image').val('');

                $("#ms_delivery_image").html("<?php echo trans('validation.attributes.message_validate_delivery_image')?>");
                $('#delivery_image').focus;
                return false;
            }


        });

        $("#form_cancled").submit(function (e) {
            var cancled_note = $("#cancled_note").val();

            if (cancled_note == '') {
                $("#cancled_note").focus();
                $("#mss_cancled_note").html("<?php echo trans('validation.attributes.message_validate_note')?>");
                return false;
            }
        });

        $("#form_payment_channel").submit(function (e) {
            var payment_channel = $("#payment_channel option:selected").val();
            if(payment_channel == ''){
                $('#payment_channel').focus();
                $("#ms_payment_channel").html("<?php echo trans('messages.message_validate_order_channel')?>");
                return false;
            }
        })
    });

</script>
@endpush


