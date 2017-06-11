<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form method="post" action="{{url('user/recommend-promotion/'.$item->id)}}">
                {{csrf_field()}}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ trans('messages.text_recomment_promotion') }}</h4>
                </div>
                <div class="modal-body">
                    @if (!empty(Session::get('error_recomment')))
                        <div class="alert alert-danger">
                            <strong>{{ Session::get('error_recomment') }} </strong>
                        </div>
                    @endif
                    {{--<div class="form-group">--}}
                        {{--<strong>* {{ trans('messages.text_email') }} :</strong>--}}
                        {{--<span style="color: #ff2222">( {{ trans('messages.text_example_email') }})</span>--}}
                        {{--<input type="text" name="email" class="form-control" id="tokenfield" value=""/>--}}
                    {{--</div>--}}

                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#input_detail">
                                {{ trans('messages.text_input_detail_promotion')}}
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" id="box_preview_template" href="#preview_template">
                                {{ trans('messages.text_ex_email_seand')}}
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content" style="padding-top: 18px;">
                        <div id="input_detail" class="tab-pane fade in active">

                            <div class="form-group">
                                <strong>{{ trans('messages.text_input_detail_promotion') }} :</strong>
                                <textarea name="detail" id="textarea_detail" class="form-control" rows="12"></textarea>
                            </div>
                        </div>
                        <div id="preview_template" class="tab-pane fade">
                            <h4>To : dgtfarm@gmail.com</h4>
                            <div style="margin-bottom: 10px; display: block;">
                                <strong>รายละเอียดโปรโมชั่น :</strong> <br/>
                                <p id="box_detail">ข้อความรายละเอียดโปรโมชั่น .....</p>
                            </div>
                            <div>
                                <p>
                                    สวัสดีสมาชิก DGTFarm ทางร้าน <strong>{{$shop->shop_title}}</strong> <br/>
                                    ขอเสนอโปรโมชั่น  <a href="#" style="color: #aec54b;">{{$item->promotion_title}}</a> <br/><br/>
                                    <strong>ติดต่อร้านค้า</strong> <br/>
                                    {{--ชื่อ-นามสกุล : {{$user->user_name}}--}}
                                    ที่อยู่ : {{$user->users_addressname}}
                                    ถนน: {{$user->users_street}}
                                    ตำบล : {{$user->users_district}}
                                    อำเภอ : {{$user->users_city}}
                                    จังหวัด : {{$user->users_province}}
                                    รหัสไปรษณีย์ : {{$user->users_postcode}}
                                    <br/>เบอร์มือถือ : {{$user->users_mobilephone}}
                                    <br/> URL ร้านค้า : <a href="{{url($shop->shop_name)}}" target="_blank">{{url($shop->shop_name)}}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ trans('messages.text_send_promotion') }}</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('messages.text_close') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>