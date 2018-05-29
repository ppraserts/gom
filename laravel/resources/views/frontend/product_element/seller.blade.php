<div class="row">
    <div class="col-md-6">
        <h4>ข้อมูลร้านค้า</h4>
    </div>
    <div class="col-md-6">
        @if(count($shop) > 0)
            <a class="btn btn-info btn-sm pull-right" href="{{url($shop->shop_name)}}">
                <i class="fa fa-home" aria-hidden="true"></i>
                {{trans('messages.text_go_to_shop')}}
            </a>
        @endif
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 pd-top-bottom">
    <strong>
        {{ trans('messages.text_firstname_lastname') }} :
    </strong>
    {{$productRequest->users_firstname_th.' '.$productRequest->users_lastname_th}}
</div>
<?php $result_user = auth()->guard('user')->user();?>
@if(count($result_user) > 0)
<div class="col-xs-12 col-sm-12 col-md-12">
    <strong>{{ trans('messages.text_moblie_phone') }} : </strong> {{$productRequest->users_mobilephone}}
</div>
@else
    <div class="col-xs-12 col-sm-12 col-md-12">
        <a href="{{url('user/login')}}" style="color: #aec54b;">
            {{ trans('messages.please_login_to_see_the_information') }}
        </a>
    </div>
@endif
<div class="col-xs-12 col-sm-12 col-md-12 pd-top-bottom">
    <strong>{{ trans('messages.text_email') }} : </strong>
    @if(!empty($productRequest->email))
        {{$productRequest->email}}
    @else
        -
    @endif
</div>
<div class="col-xs-12 col-sm-12 col-md-12 pd-top-bottom">
    <strong>{{ trans('messages.text_address') }} : </strong>
    <?php
    if (!empty($productRequest->users_addressname)) {
        $address = $productRequest->users_addressname;

        if (!empty($productRequest->users_district)) {
            $address .= ' ' . trans('messages.text_sub_district') . ' : ' . $productRequest->users_district;
        } else {
            $address .= ' ' . trans('messages.text_sub_district') . ' : -';
        }
        if (!empty($productRequest->users_city)) {
            $address .= '<br/>' . trans('messages.text_district') . ' : ' . $productRequest->users_city;
        } else {
            $address .= '<br/>' . trans('messages.text_district') . ' : -';
        }
        if (!empty($productRequest->users_province)) {
            $address .= ' ' . trans('messages.orderbyprovince') . ' : ' . $productRequest->users_province;
        } else {
            $address .= ' ' . trans('messages.orderbyprovince') . '  : -';
        }
        if (!empty($productRequest->users_postcode)) {
            $address .= '<br/>' . trans('messages.text_zip_code') . ' : ' . $productRequest->users_postcode;
        } else {
            $address .= '<br/>' . trans('messages.text_zip_code') . ' : -';
        }
    }
    ?>
    @if(!empty($address))
        {!! $address !!}
    @else
        -
    @endif
    <div class="clearfix" style="border-top: 1px solid #d4d4d4; padding:0px; margin-top: 15px;"></div>
    <h4>{{trans('messages.standard_received')}}</h4>
    <button type="button" class="btn btn-info btn-sm" style="width: 100%; margin-bottom: 5px;">
        <?php $c = 0; $count_standards = count($standards); ?>
        @foreach($standards as $standard)
            <?php $commact = '';?>
            @if($c < $count_standards && $count_standards != 1)
                    <?php $commact = ',';?>
            @endif
            {{$standard->name}}{{$commact}}
            <?php $c++?>
        @endforeach
    </button>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="clearfix" style="border-top: 1px solid #d4d4d4; padding-bottom: 10px;"></div>
        <h4>{{ $productRequest->product_name_th }}</h4>
        @if(!empty($productRequest->product_title))
        <p>
            <span class="glyphicon glyphicon-tag"></span>
            {{ $productRequest->product_title }}
        </p>
        @endif
        @if(!empty($productRequest->province))
        <p>
            <span class="glyphicon glyphicon-map-marker"></span>
            {{ $productRequest->province }}
        </p>
        @endif
        <?php
        $avg_score = 0;
        if (!empty($productRequest->avg_score)) {
            $avg_score = round($productRequest->avg_score);
        }
        ?>
        <p class="score-star">
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

        </p>
        <p>
            @if($productRequest->add_packing == 1)
                {{ trans('validation.attributes.product_package_size') }} {{$productRequest->packing_size}} {{$productRequest->package_unit}}
            @endif
        </p>
        <p>
            {{ trans('validation.attributes.price') }} :
            <strong>
                @if($productRequest->iwantto == "buy")
                    {{ floatval($productRequest->pricerange_start) }}
                    - {{ floatval($productRequest->pricerange_end) }}
                @endif
                @if($productRequest->iwantto == "sale")
                    @if($productRequest->is_showprice)
                        {{ floatval($productRequest->price) }} {{ trans('messages.baht') }}/{{$productRequest->units}}
                    @endif
                    @if(!$productRequest->is_showprice)
                        {{ trans('messages.product_no_price') }}
                    @endif
                @endif
            </strong>
        </p>
        <p>
            @if($productRequest->iwantto == "sale")
                @if($productRequest->add_packing == 1)
                    {{ trans('validation.attributes.product_package_size') }} :
                    <strong>{{$productRequest->packing_size}} {{$productRequest->package_unit}}</strong>
                @endif
            @endif
        </p>
        <p>
            {{ trans('validation.attributes.volumn') }} :
            <strong>
                @if($productRequest->iwantto == "buy")
                    {{ floatval($productRequest->volumnrange_start) }}
                    - {{ floatval($productRequest->volumnrange_end) }}  {{ $productRequest->units }}
                @endif
                @if($productRequest->iwantto == "sale")
                    {{ floatval($productRequest->volumn) }} {{ $productRequest->units }}
                @endif
            </strong>
        </p>
        @if($user!=null && $user->id == $productRequest->users_id)
            <p>
                <a href="{{ url('user/productsaleedit/'.$productRequest->id)  }}"
                   class="btn btn-primary">
                    <span class="glyphicon glyphicon-pencil"></span> {{trans('messages.edit')}}
                </a>
            </p>
        @else
            @if($user==null || ($user!=null && $user->iwanttobuy == 'buy'))
                @if($productRequest->iwantto == "sale")
                    @if(($productRequest['selling_type'] == "all" || $productRequest['selling_type'] == "retail") && $productRequest['productstatus'] == "open" && $productRequest['product_stock'] >0)
                        <button type="button"
                                onclick="addToCart('{{$productRequest['id']}}' , '{{$productRequest['users_id']}}' , '{{$productRequest['price']}}' , '{{$productRequest['min_order']}}')"
                                class="btn btn-primary">
                            <i class="fa fa-shopping-cart"></i> {{trans('messages.add_to_cart')}}
                        </button>

                    @endif
                @endif
            @endif
            @if($user==null || ($user!=null && $user->iwanttobuy == 'buy'))
                @if($productRequest->iwantto == "sale")
                    @if(($productRequest['selling_type'] == "all" || $productRequest['selling_type'] == "wholesale") && $productRequest['productstatus'] == "open")
                        <button class="btn btn-primary" onclick="showAddQuotation()">
                            {{trans('messages.quotation_request')}}</button>
                    @endif
                @endif
            @endif
        @endif
    </div>
</div>