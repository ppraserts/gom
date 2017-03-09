@extends('layouts.main')
@section('content')
@include('shared.usermenu', array('setActive'=>'theme'))
<?php
    $theme_name_1 = "theme1";
    $theme_name_2 = "theme2";
    $theme_name_3 = "theme3";
?>

<br/>
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="hover ehover1 classWithPad">
            <img class="img-responsive" src="/images/small_theme1.png" alt="">
            <div class="overlay">
                <h2>รูปแบบที่ 1</h2>
                <button class="info" data-toggle="modal" data-target="#modal1">ดูตัวอย่าง</button>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="hover ehover1 classWithPad">
            <img class="img-responsive" src="/images/small_theme2.png" alt="">
            <div class="overlay">
                <h2>รูปแบบที่ 2</h2>
                <button class="info" data-toggle="modal" data-target="#modal2">ดูตัวอย่าง</button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="hover ehover1 classWithPad">
            <img class="img-responsive" src="/images/small_theme3.png" alt="">
            <div class="overlay">
                <h2>รูปแบบที่ 3</h2>
                <button class="info" data-toggle="modal" data-target="#modal3">ดูตัวอย่าง</button>
            </div>
        </div>
    </div>
</div>

<!-- modals; the pop up boxes that contain the code for the effects -->
<div id="modal1" class="modal fade" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog modal-lg vertical-align-center">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-primary">รูปแบบที่ 1</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <img class="img-responsive" src="/images/theme1.png" alt="">
                            <BR>
                            <p>รายละเอียดเกี่ยวกับธีม</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ url('user/theme/create?theme='.$theme_name_1) }}" type="button" class="btn btn-primary">นำไปใช้</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal -->

<div id="modal2" class="modal fade" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog modal-lg vertical-align-center">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">รูปแบบที่ 2</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <img class="img-responsive" src="/images/theme2.png" alt="">
                            <BR>
                            <p>รายละเอียดเกี่ยวกับธีม</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ url('user/theme/create?theme='.$theme_name_2) }}" type="button" class="btn btn-primary">นำไปใช้</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                </div>
            </div><!-- /.modal-content -->
        </div>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="modal3" class="modal fade" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog modal-lg vertical-align-center">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">รูปแบบที่ 3</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <img class="img-responsive" src="/images/theme3.png" alt="">
                            <BR>
                            <p>รายละเอียดเกี่ยวกับธีม</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ url('user/theme/create?theme='.$theme_name_3) }}" type="button" class="btn btn-primary">นำไปใช้</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div><!-- /.modal -->

@stop
