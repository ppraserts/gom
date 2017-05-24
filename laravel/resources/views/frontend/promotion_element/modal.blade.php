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
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>{{ trans('messages.message_whoops_error')}}</strong>
                            <br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <strong>{{ trans('messages.text_email') }} :</strong>
                        <span style="color: #ff2222">( {{ trans('messages.text_example') }} test@gmail.com,test2@hotmail.com, )</span>
                        <input type="text" name="email" class="form-control" id="tokenfield" value=""/>
                    </div>
                    <div class="form-group">
                        <strong>* {{ trans('messages.Description') }}:</strong>
                        <textarea name="detail" class="form-control" rows="12"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ trans('messages.text_send_promotion') }}</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>