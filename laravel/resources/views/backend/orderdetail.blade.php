<?php
$pagetitle = trans('messages.order_detail');
?>
@extends('layouts.dashboard')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="glyphicon glyphicon-apple"></i>')
@section('section')
    <?php
    $actionSetActive ='';
    if(!empty(Session::get('orderType')) and Session::get('orderType') == 'sale'){
       $actionSetActive ='shoporder';
    }elseif(!empty(Session::get('orderType')) and Session::get('orderType') == 'buy'){
        $actionSetActive ='order';
    }
    ?>
    <div class="col-sm-12">
        <div class="row">
            @if(!empty(Session::get('orderType')) and Session::get('orderType') == 'sale')
                <h2>{{ trans('messages.order_detail_sale') }}</h2>
            @elseif(!empty(Session::get('orderType')) and Session::get('orderType') == 'buy')
                <h2>{{ trans('messages.order_detail') }}</h2>
            @endif
            <div class="col-md-4">
                <div class="row">
                    <?php
                      $statusHistory_n = count($order->statusHistory);
                    ?>
                    <h3>{{ trans('messages.order_id') . " : " . $order->id }}</h3>
                    <p><b>{{ trans('messages.order_date') }} : </b>{{\App\Helpers\DateFuncs::mysqlToThaiDate($order->order_date,false)}}</p>
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

                                <th width="70px" style="text-align:center;">{{ trans('messages.no') }}</th>
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
            @if($order->order_status >= 3)
                @include('frontend.order_element.user_buy_order_delivery')
            @else
                @include('frontend.order_element.list_order_delivery')
            @endif
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
                                            วันที่จัดส่ง :{{\App\Helpers\DateFuncs::mysqlToThaiDate($item->order_date)}} <br/>
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
        </div>
        <div class="row">
            <a href="{{url('admin/orderdetail/pdf/'.$order->id)}}" class="btn btn-primary pull-right">
                <span class="glyphicon glyphicon-export"></span> {{trans('messages.download_pdf')}}
            </a>
        </div>

    </div>
@endsection
