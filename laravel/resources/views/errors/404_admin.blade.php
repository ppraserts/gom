@extends('layouts.error_admin')
@section('content')
    @if(Lang::locale() == "th")
        <div class="row" style="background-color: white; padding-top: 10px; padding-bottom: 25px; ">
            {{--<div class="col-md-4" style="font-size: 102px; text-align: center "> 404 </div>--}}
            <div class="col-md-12" style="font-size: 16px; text-align: center;">
                <h1>ขออภัยค่ะ</h1>
                <p>หน้าเว็บที่ร้องขอไม่พบบนเซิร์ฟเวอร์ของเราหรือเซิร์ฟเวอร์ประมวลผลผิดพลาดกรุณา</p>
                <p class="box_header_username">
                    กลับไปที่
                    <a href="javascript:history.go(-1)">หน้าก่อนหน้านี้</a>
                    หรือเยี่ยมชม
                    @if( Request::segment(1) == 'user')
                        <a href="{{url('user/userprofiles')}}">โฮมเพจ</a>
                    @elseif( Request::segment(1) == 'admin')
                        <a href="{{url('admin/adminteam')}}">โฮมเพจ</a>
                    @else
                        <a href="{{url('/')}}">โฮมเพจ</a>
                    @endif

                </p>
            </div>
        </div>
    @else
        <div class="row" style="background-color: white; padding-top: 10px; padding-bottom: 25px; ">
            {{--<div class="col-md-4" style="font-size: 102px; text-align: center "> 404 </div>--}}
            <div class="col-md-12" style="font-size: 16px; text-align: center; ">
                <h1>SORRY!</h1>
                <p>The Page You Requested Could Not Be Found On Our Server</p>
                <p class="box_header_username">
                    Go back to the
                    <a href="javascript:history.go(-1)">Previous page</a>
                    or visit our
                    @if( Request::segment(1) == 'user')
                        <a href="{{url('user/userprofiles')}}">Homepage</a>
                    @elseif( Request::segment(1) == 'admin')
                        <a href="{{url('admin/adminteam')}}">Homepage</a>
                    @else
                        <a href="{{url('/')}}">Homepage</a>
                    @endif
                </p>
            </div>
        </div>
    @endif
@stop
