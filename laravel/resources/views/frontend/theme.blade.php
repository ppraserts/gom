@extends('layouts.main')
@section('content')
    @include('shared.usermenu', array('setActive'=>'theme'))
    <br/>
    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="hover ehover1 classWithPad">
                <img class="img-responsive" src="/images/theme1.png" alt="">
                <div class="overlay">
                    <h2>รูปแบบที่ 1</h2>
                    <button class="info" data-toggle="modal" data-target="#modal1">ดูตัวอย่าง</button>
                    <button class="info">นำไปใช้</button>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="hover ehover1 classWithPad">
                <img class="img-responsive" src="http://placehold.it/800x600" alt="">
                <div class="overlay">
                    <h2>รูปแบบที่ 2</h2>
                    <button class="info" data-toggle="modal" data-target="#modal2">ดูตัวอย่าง</button>
                    <button class="info">นำไปใช้</button>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="hover ehover1 classWithPad">
                <img class="img-responsive" src="http://placehold.it/800x600" alt="">
                <div class="overlay">
                    <h2>รูปแบบที่ 3</h2>
                    <button class="info" data-toggle="modal" data-target="#modal3">ดูตัวอย่าง</button>
                    <button class="info">นำไปใช้</button>
                </div>
            </div>
        </div>
    </div>


    {{--<div class="row">--}}
        {{--<div class="grid">--}}
            {{--<figure class="effect-zoe">--}}
                {{--<img src="/images/theme1.png" alt="img25"/>--}}
                {{--<figcaption>--}}
                    {{--<h2>Creative <span>Zoe</span></h2>--}}
                    {{--<p class="icon-links">--}}
                        {{--<a href="#"><span class="icon-heart"></span></a>--}}
                        {{--<a href="#"><span class="icon-eye"></span></a>--}}
                        {{--<a href="#"><span class="icon-paper-clip"></span></a>--}}
                    {{--</p>--}}
                {{--</figcaption>--}}
            {{--</figure>--}}
            {{--<figure class="effect-zoe">--}}
                {{--<img src="/images/theme1.png" alt="img26"/>--}}
                {{--<figcaption>--}}
                    {{--<h2>Creative <span>Zoe</span></h2>--}}
                    {{--<p class="icon-links">--}}
                        {{--<a href="#"><span class="icon-heart"></span></a>--}}
                        {{--<a href="#"><span class="icon-eye"></span></a>--}}
                        {{--<a href="#"><span class="icon-paper-clip"></span></a>--}}
                    {{--</p>--}}
                {{--</figcaption>--}}
            {{--</figure>--}}
            {{--<figure class="effect-zoe">--}}
                {{--<img src="/images/theme1.png" alt="img26"/>--}}
                {{--<figcaption>--}}
                    {{--<h2>Creative <span>Zoe</span></h2>--}}
                    {{--<p class="icon-links">--}}
                        {{--<a href="#"><span><i class="fa fa-save"></i></span></a>--}}
                        {{--<a href="#"><span class="icon-eye"></span></a>--}}
                        {{--<a href="#"><span class="icon-paper-clip"></span></a>--}}
                    {{--</p>--}}
                {{--</figcaption>--}}
            {{--</figure>--}}
        {{--</div>--}}

    {{--</div>--}}

    <!-- modals; the pop up boxes that contain the code for the effects -->
    <div id="modal1" class="modal fade" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog modal-lg vertical-align-center">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">รูปแบบที่ 1</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="container">
                                <img class="img-responsive" src="/images/theme1.png" alt="">
                            </div>
                            <p>One fine body&hellip;</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">รูปแบบที่ 2</h4>
                    </div>
                    <div class="modal-body">
                        <p>One fine body&hellip;</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">รูปแบบที่ 3</h4>
                    </div>
                    <div class="modal-body">
                        <p>One fine body&hellip;</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </div><!-- /.modal -->

@stop
