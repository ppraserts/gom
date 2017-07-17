<div class="col-sm-12 col-md-12">
    @php
        $getUser = auth()->guard('user')->user();
        $user_address = DB::table('users')->where('id' , $getUser->id)->first();
        $users_addressname = '-';
        if(!empty($user_address->users_addressname)){ $users_addressname = $user_address->users_addressname; }
        $users_street = '-';
        if(!empty($user_address->users_street)){ $users_street = $user_address->users_street; }
        $users_district = '-';
        if(!empty($user_address->users_district)){ $users_district = $user_address->users_district; }
        $users_city = '-';
        if(!empty($user_address->users_city)){ $users_city = $user_address->users_city; }
        $users_province = '-';
        if(!empty($user_address->users_province)){ $users_province = $user_address->users_province; }
        $users_postcode = '-';
        if(!empty($user_address->users_postcode)){ $users_postcode = $user_address->users_postcode; }
        $address = trans('messages.addr_no').': '.$users_addressname.trans('validation.attributes.users_street').': '.$users_street.trans('messages.text_sub_district').' : '.$users_district.trans('messages.text_district').': '.$users_city.' '.trans('messages.orderbyprovince').': '.$users_province.trans('messages.text_zip_code').': '.$users_postcode;
    @endphp
    <div class="form-group ">
        <strong> * {{ trans('messages.text_delivery_channel') }} :</strong>
        <select id="delivery_chanel" class="form-control" name="delivery_chanel" onchange="hsHtml()" id="payment_channel" style="margin-bottom: 5px;">
            <option value="จัดส่งตามที่อยู่">{{trans('messages.shipping_addr')}}</option>
            <option value="รับเอง">{{trans('messages.self_receive')}}</option>
        </select>
        <span id="mss_delivery_chanel" class="alert-danger"></span>
        <textarea id="hd_address_delivery" style="display: none">{{$address}}</textarea>
    </div>
    <div class="form-group" id="address_hidden">
        <strong> * {{ trans('messages.text_address_delivery') }} :</strong>
        <textarea name="address_delivery" id="address_delivery" class="form-control" style="margin-bottom: 5px;">{{$address}}</textarea>
        <span id="mss_address_delivery" class="alert-danger"></span>
    </div>
</div>