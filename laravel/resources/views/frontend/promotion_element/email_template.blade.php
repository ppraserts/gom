<!DOCTYPE html>
<html lang=&quot;en-US&quot;>
<head>
    <meta charset=&quot;utf-8&quot;>
</head>
<body>
<h4>To : {{$email}}</h4>
<div>
    <p>
        สวัสดีสมาชิก DGTFarm ทางร้าน <strong>{{$shop_title}}</strong> <br/>
        ขอเสนอโปรโมชั่น  <a href="{{$link.'?rid='.$pormotion_recomment_id.'&key='.$encode_id}}" target="_blank">{{$promotion_title}}</a><br/><br/>
    </p>
</div>
<div style="margin-bottom: 10px; display: block;">
    <strong>รายละเอียดโปรโมชั่น :</strong>
    <p>{!! $detail !!}</p>
</div>
<div>
    <p>
        <strong>ติดต่อร้านค้า</strong> <br/>
        ที่อยู่ : {{$users_addressname}}
        ถนน: {{$users_street}}
        ตำบล : {{$users_district}}
        อำเภอ : {{$users_city}}
        จังหวัด : {{$users_province}}
        รหัสไปรษณีย์ : {{$users_postcode}}
        <br/>เบอร์มือถือ : {{$users_mobilephone}}
        <br/> URL ร้านค้า : <a href="{{url($shop_name)}}" target="_blank">{{url($shop_name)}}</a>
        <br/> หากต้องการยกเลิกรับข่าวสารจาก DGTFarm <a href="{{url('unsubscribe?uemail='.$email.'&key='.md5($email))}}" target="_blank">คลิก</a>
    </p>
</div>
</body>
</html>