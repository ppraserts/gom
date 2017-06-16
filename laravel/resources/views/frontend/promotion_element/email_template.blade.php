<!DOCTYPE html>
<html lang=&quot;en-US&quot;>
<head>
    <meta charset=&quot;utf-8&quot;>
</head>
<body>
<h4>เรียน คุณ {{$user_name}}</h4>
<div>
    <p>
        ตามที่ท่านได้สมัครสมาชิกกับเว็บไซต์ www.DGTFarm.com ไว้<br/>

        ขณะนี้ ทางร้านค้า{{$shop_title}} มีโปรโมชั่นดีๆ ที่น่าสนใจมานำเสนอ ท่านสามารถคลิกดูรายละเอียดเพิ่มเติมได้ที่
        <a href="{{$link.'?rid='.$pormotion_recomment_id.'&key='.$encode_id}}"
           target="_blank">{{empty($promotion_title) ? $link.'?rid='.$pormotion_recomment_id.'&key='.$encode_id : $promotion_title}}</a><br/><br/>
    </p>
    <p>
        นอกจากนี้ยังมีสินค้าเกษตรคุณภาพอื่นๆ อีกมากมายให้ท่านได้เลือกซื้อเลือกชมได้ที่ <a href="{{url($shop_name)}}"
                                                                                          target="_blank">{{url($shop_name)}}</a>
    </p>
    <p><strong>ขอแสดงความนับถือ</strong></p>
    <br/>
    <p>***หากท่านประสงค์ไม่ขอรับอีเมล์จากเว็บไซต์นี้ (www.DGTFarm.com) อีก <a href="{{url('unsubscribe?uemail='.$email.'&key='.md5($email))}}" target="_blank">กรุณาคลิกที่นี่</a></p>
</div>

<div>

    <strong>ร้าน{{$shop_title}}</strong> <br/>
    ที่อยู่ : {{$users_addressname . " "}}
    @if(!empty($users_street)){{$users_street . " "}}@endif
    @if(!empty($users_district)){{$users_district . " "}}@endif
    @if(!empty($users_city)){{$users_city . " "}}@endif
    @if(!empty($users_province)){{$users_province . " "}}@endif
    @if(!empty($users_postcode)){{$users_postcode . " "}}@endif

    @if(!empty($users_mobilephone))
        <br/>เบอร์โทรศัพท์  : {{$users_mobilephone}}
    @endif

</div>
</body>
</html>