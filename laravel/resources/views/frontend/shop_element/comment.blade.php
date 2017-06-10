<div class="detailBox" id="commentBox">
    <div class="titleBox">
        <label>
            <i class="fa fa-commenting" aria-hidden="true"></i>
            {{ trans('messages.text_comments')}}
        </label>
        <input type="hidden" id="shop_name" value="{{$shop->shop_name}}">
    </div>
    <div class="commentBox row">
        <div class="col-md-8">
            <p>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>{{ trans('messages.message_whoops_error')}}</strong> {{ trans('messages.message_result_error')}}
                    <br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif
                </p>
                <p class="ratingFormDesc">
                    {{ trans('messages.text_share_comment')}}
                </p>
                <label class="ratingStarsTitle">{{ trans('messages.text_rate_shop')}}</label>
                <form class="form-horizontal" method="post" action="{{url(Request::segment(1).'/'.$shop->id.'/'.md5($shop->id))}}">
                    {{csrf_field()}}
                    <div class="stars">
                        <input class="star star-5" id="star-5" type="radio" name="star" checked value="5"/>
                        <label class="star star-5" for="star-5"></label>
                        <input class="star star-4" id="star-4" type="radio" name="star" value="4"/>
                        <label class="star star-4" for="star-4"></label>
                        <input class="star star-3" id="star-3" type="radio" name="star" value="3"/>
                        <label class="star star-3" for="star-3"></label>
                        <input class="star star-2" id="star-2" type="radio" name="star" value="2"/>
                        <label class="star star-2" for="star-2"></label>
                        <input class="star star-1" id="star-1" type="radio" name="star" value="1"/>
                        <label class="star star-1" for="star-1"></label>

                    </div>
                    <div class="clearfix"></div>
                    <label for="comment">{{ trans('messages.text_type_comment_here')}}:</label>
                    <textarea class="form-control" rows="7" placeholder="{{ trans('messages.text_type_comment_here')}}" name="comment"></textarea>
                    <button type="submit" class="btn btn-warning pull-right">{{ trans('messages.text_send_comment')}}</button>
                </form>
                <div class="clearfix"></div>
                <div class="actionBox">
                    <ul class="commentList">
                        <?php $score=0; $i=0;?>
                        @if(count($comments) > 0)
                            @foreach($comments as $comment)
                                <?php
                                $i++;
                                if(!empty($comment->score)){
                                    $score = $score+$comment->score;
                                }
                                ?>
                                @if(!empty($status_comment) and $status_comment == 1 and $comment->status == 1)
                                    @include('frontend.shop_element.list_comment')
                                @elseif(!empty($status_comment) and $status_comment == 1 and $comment->status == 0)
                                    @include('frontend.shop_element.list_comment')
                                @elseif(empty($status_comment) and $comment->status == 1)
                                    @include('frontend.shop_element.list_comment')
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div>
                @if(count($comments) > 0)
                    {!! $comments->appends(Request::all()) !!}
                @endif
        </div>

        <div class="col-md-4">
            <?php
            $avg_score = 0;
            if(!empty($score)){
                $avg_score = round($score/$i);
            }
            ?>
            <h3>คะแนนของร้านค้านี้ :</h3>

            <p class="score-star" style="font-size: 28px;">
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
            <h3>การเขียนรีวิวที่ถูกวิธี</h3>
            <h4>สิ่งที่ควรทำ</h4>
            <ul>
                <li>เน้นเฉพาะคุณสมบัติของร้านค้า</li>
                <li>แสดงความคิดเห็นตามประสบการณ์โดยตรงของคุณ</li>
                <li>โปรดช่วยอธิบายเพิ่มเติมว่าทำไมคุณถึงแสดงความคิดเห็นเช่นนั้น</li>
            </ul>
            <br>
            <h4>แสดงความคิดเห็นที่ไม่เกี่ยวข้องกับร้านค้าโดยตรง</h4>
            <ul>
                <li>กรุณาอย่าแสดงความคิดเห็นที่ไม่เป็นความจริง เบี่ยงเบนหรือนำไปสู่ในทางที่ไม่เป็นจริง</li>
                <li>ใช้ คำดูหมิ่น หยายคาย ลามก ทำลายชื่อเสียง ข่มขู่ หรือ ภาษาดูถูกผู้อื่น</li>
                <li>เปิดเผยข้อมูลส่วนตัวของผู้อื่น</li>
                <li>ใส่ลิ้งค์ที่ไม่เกี่ยวข้องกับ DGTFarm</li>
                <li>ใส่ลิ้งค์เครื่องหมายการค้าที่ไม่ได้รับอนุญาติ หรือ เนื้อหาที่ละเมิดลิขสิทธ์</li>
            </ul>
        </div>

    </div>
</div>
