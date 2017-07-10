<h4>ข้อมูลผู้ซื้อ</h4>
<div class="col-xs-12 col-sm-12 col-md-12 pd-top-bottom">
    <strong>{{ trans('messages.text_firstname_lastname') }} : </strong> {{$productRequest->users_firstname_th.' '.$productRequest->users_lastname_th}}
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
    <strong>{{ trans('messages.text_moblie_phone') }} : </strong> {{$productRequest->users_mobilephone}}
</div>
<div class="col-xs-12 col-sm-12 col-md-12 pd-top-bottom">
    <strong>{{ trans('messages.text_phone') }} : </strong>
    @if(!empty($productRequest->users_phone))
        {{$productRequest->users_phone}}
    @else
        -
    @endif
</div>
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
        if (!empty($productRequest->users_street)) {
            $address .= ' '.trans('messages.text_road').' : ' . $productRequest->users_street;
        } else {
            $address .= ' '.trans('messages.text_road').' : -';
        }
        if (!empty($productRequest->users_district)) {
            $address .= ' '.trans('messages.text_sub_district').' : ' . $productRequest->users_district;
        } else {
            $address .= ' '.trans('messages.text_sub_district').' : -';
        }
        if (!empty($productRequest->users_city)) {
            $address .= '<br/>'.trans('messages.text_district').' : ' . $productRequest->users_city;
        } else {
            $address .= '<br/>'.trans('messages.text_district').' : -';
        }
        if (!empty($productRequest->users_province)) {
            $address .= ' '.trans('messages.orderbyprovince').' : ' . $productRequest->users_province;
        } else {
            $address .= ' '.trans('messages.orderbyprovince').'  : -';
        }
        if (!empty($productRequest->users_postcode)) {
            $address .= '<br/>'.trans('messages.text_zip_code').' : ' . $productRequest->users_postcode;
        } else {
            $address .= '<br/>'.trans('messages.text_zip_code').' : -';
        }
    }
    ?>
    @if(!empty($address))
        {!! $address !!}
    @else
        -
    @endif
</div>
