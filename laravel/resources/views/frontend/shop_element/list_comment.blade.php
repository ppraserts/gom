<li>
    <div class="commenterImage">
        <i class="fa fa-user-circle-o" aria-hidden="true"></i>
    </div>
    <div class="commentText">
        <p>
            {{$comment->users_firstname_th.' '.$comment->users_lastname_th}}
        </p>
        <p class="score-star">
            @if($comment->score == 1)
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star-o" aria-hidden="true"></i>
                <i class="fa fa-star-o" aria-hidden="true"></i>
                <i class="fa fa-star-o" aria-hidden="true"></i>
                <i class="fa fa-star-o" aria-hidden="true"></i>
            @elseif($comment->score == 2)
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star-o" aria-hidden="true"></i>
                <i class="fa fa-star-o" aria-hidden="true"></i>
                <i class="fa fa-star-o" aria-hidden="true"></i>
            @elseif($comment->score == 3)
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star-o" aria-hidden="true"></i>
                <i class="fa fa-star-o" aria-hidden="true"></i>
            @elseif($comment->score == 4)
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star-o" aria-hidden="true"></i>
            @elseif($comment->score == 5)
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
            @elseif($comment->score == 0)
                <i class="fa fa-star-o" aria-hidden="true"></i>
                <i class="fa fa-star-o" aria-hidden="true"></i>
                <i class="fa fa-star-o" aria-hidden="true"></i>
                <i class="fa fa-star-o" aria-hidden="true"></i>
                <i class="fa fa-star-o" aria-hidden="true"></i>
            @endif

        </p>
        <p class="">
            {!! $comment->comment !!}
        </p>
        <span class="date sub-text">
                                            {{ trans('messages.text_date')}}:
            {{\App\Helpers\DateFuncs::mysqlToThaiDate($comment->created_at)}}
                                        </span>
        @if(!empty($status_comment) and $status_comment == 1)
            <p>

                <button @if($comment->status == 1)disabled @endif type="button" id="show_{{$comment->id}}" class="btn btn-info statusEventShow" data-id="{{$comment->id}}">
                    แสดง
                </button>

                <button @if($comment->status == 0)disabled @endif type="button" id="hidden_{{$comment->id}}" class="btn btn-warning statusEventHidden" data-id="{{$comment->id}}">
                    ซ่อน
                </button>
            </p>
        @endif

    </div>
</li>