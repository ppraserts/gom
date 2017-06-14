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
                        {{--<li class="active">
                            <a data-toggle="tab" href="#input_detail">
                                {{ trans('messages.text_input_detail_promotion')}}
                            </a>
                        </li>--}}
                        <li class="active">
                            <a data-toggle="tab" id="box_preview_template" href="#preview_template">
                                {{ trans('messages.text_ex_email_seand')}}
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content" style="padding-top: 18px;">
                        {{--<div id="input_detail" class="tab-pane fade in active">

                            <div class="form-group">
                                <strong>{{ trans('messages.text_input_detail_promotion') }} :</strong>
                                <textarea name="detail" id="textarea_detail" class="form-control" rows="12"></textarea>
                            </div>
                        </div>--}}
                        <div id="preview_template" class="tab-pane fade in active">
                            <div>
                                <h4>เรียน คุณ {{$user->users_firstname_th . " ".$user->users_lastname_th}}</h4>
                                <div>
                                    <p>
                                        ตามที่ท่านได้สมัครสมาชิกกับเว็บไซต์ www.DGTFarm.com ไว้<br/>

                                        ขณะนี้ ทางร้านค้า{{$shop->shop_title}} มีโปรโมชั่นดีๆ ที่น่าสนใจมานำเสนอ ท่านสามารถคลิกดูรายละเอียดเพิ่มเติมได้ที่
                                        <a href="{{url($shop->shop_name."/promotion/".$item->id)}}"
                                           target="_blank">{{url($shop->shop_name."/promotion/".$item->id)}}</a><br/><br/>
                                    </p>
                                    <p>
                                        นอกจากนี้ยังมีสินค้าเกษตรคุณภาพอื่นๆ อีกมากมายให้ท่านได้เลือกซื้อเลือกชมได้ที่ <a href="{{url($shop->shop_name)}}"
                                                                                                                          target="_blank">{{url($shop->shop_name)}}</a>
                                    </p>
                                    <br/>
                                    <p><strong>ขอแสดงความนับถือ</strong></p>
                                    <br/>
                                    <br/>
                                    <p>***หากท่านประสงค์ไม่ขอรับอีเมล์จากเว็บไซต์นี้ (www.DGTFarm.com) อีก กรุณาคลิกที่นี่</p>
                                </div>

                                <div>
                                    <strong>ร้าน{{$shop->shop_title}}</strong> <br/>
                                    ที่อยู่ : {{$user->users_addressname . " "}}
                                    @if(!empty($user->users_street)){{$user->users_street . " "}}@endif
                                    @if(!empty($user->users_district)){{$user->users_district . " "}}@endif
                                    @if(!empty($user->users_city)){{$user->users_city . " "}}@endif
                                    @if(!empty($user->users_province)){{$user->users_province . " "}}@endif
                                    @if(!empty($user->users_postcode)){{$user->users_postcode . " "}}@endif

                                    @if(!empty($user->users_mobilephone))
                                        <br/>เบอร์โทรศัพท์  : {{$user->users_mobilephone}}
                                    @endif

                                </div>
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