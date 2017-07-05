@extends('layouts.dashboard')
@section('section')
    <div class="col-sm-12" style="padding: 10px 25px; border: 1px solid #ddd; margin-top: 15px;">
        <div class="row">
            @include('backend.reports.menu_reports')
        </div>
        @if (count($errors) > 0)
            <div class="row" style="margin-top: 15px;">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        <div class="row text-center">
            <h2>{{ trans('messages.text_report_menu_order_history_sale_buy') }}</h2>
        </div>
        <form action="{{url('admin/reports/order-history-sale-buy')}}" method="POST">
            {{csrf_field()}}
            <div class="row">
                <div class="form-group col-sm-6">
                    <strong style="padding-right: 0; padding-left: 0;">*
                        {{ trans('messages.type_sale_buy') }}:
                    </strong>
                    <select name="type_sale_buy" id="type_sale_buy" class="form-control">
                        <option value="">{{ trans('messages.please_select') }}</option>
                        <option value="sale" @if(!empty($type_sale_buy) and $type_sale_buy == 'sale') selected @endif>
                            {{ trans('messages.i_sale') }}
                        </option>
                        <option value="buy" @if(!empty($type_sale_buy) and $type_sale_buy == 'buy') selected @endif>
                            {{ trans('messages.i_buy') }}
                        </option>
                    </select>
                </div>
                <div class="form-group col-sm-6">
                    <strong style="padding-right: 0; padding-left: 0;">*
                        {{ trans('messages.member') }}:
                    </strong>
                    <select class="selectpicker form-control" name="user" id="user"
                            data-live-search="true">
                        @if(count($users) > 0)
                            <option value="">{{ trans('messages.please_select') }}</option>
                            @foreach($users as $user)
                                <option value="{{$user->id}}"
                                        @if(!empty($user_id) and $user_id == $user->id) selected @endif>
                                    @if(!empty($user->users_firstname_th))
                                        {{$user->users_firstname_th .' '. $user->users_lastname_th}}
                                    @else
                                        {{$user->users_firstname_en .' '. $user->users_lastname_en}}
                                    @endif
                                </option>
                            @endforeach
                        @else
                            <option value="">{{ trans('messages.found') }}</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="text-center" style="padding-left: 0px; padding-right: 0;">
                    <button style="width: 400px;" class="btn btn-primary" type="submit">
                        <i class="fa fa-search"></i> {{ trans('messages.search') }}
                    </button>
                </div>
            </div>
        </form>

        <div class="row" style="margin-top: 10px">
            @if(!empty($results) && count($results) > 0 && count($errors) < 1)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <th width="120px" style="text-align:center;">{{ trans('messages.order_id') }}</th>
                            <th style="text-align:center;">{{ trans('messages.order_type') }}</th>
                            @if(!empty($type_sale_buy) and $type_sale_buy == 'sale')
                                <th>{{ trans('messages.i_sale') }}</th>
                            @endif
                            @if(!empty($type_sale_buy) and $type_sale_buy == 'buy')
                                <th>{{ trans('messages.i_buy') }}</th>
                            @endif
                            <th style="text-align:center;">{{ trans('messages.order_date') }}</th>
                            <th style="text-align:center;">{{ trans('messages.order_total') }}</th>
                            <th style="text-align:center;">{{ trans('messages.order_status') }}</th>
                            <th width="130px" style="text-align:center;">
                                {{ trans('messages.view_order_detail') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($results as $result)
                            <tr>
                                <td style="text-align:center;">{{ $result->id }}</td>
                                <td style="text-align:center;">
                                    {{ $result->order_type== 'retail'? trans('messages.retail'): trans('messages.wholesale')}}
                                </td>
                                @if(!empty($type_sale_buy) and $type_sale_buy == 'sale')
                                    <td>{{ $result->users_firstname_th. " ". $result->users_lastname_th }}</td>
                                @elseif(!empty($type_sale_buy) and $type_sale_buy == 'buy')
                                    <th style="font-weight: normal">
                                        {{ $result->buyer->users_firstname_th. " ". $result->buyer->users_lastname_th }}
                                    </th>
                                @endif

                                <td style="text-align:center;">{{ DateFuncs::convertToThaiDate($result->order_date) }}</td>
                                <td style="text-align:center;">{{ $result->total_amount . trans('messages.baht') }}</td>
                                <td style="text-align:center;">{{ $result->status_name }}</td>
                                <td style="text-align:center;">
                                    <a class="btn btn-info"
                                       href="{{ url ('admin/reports/orderdetail/'.$result->id) }}">
                                        <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="col-md-6">{!! $results->appends(Request::all()) !!}</div>
                <div class="col-md-6">
                    <div class="col-md-12" style="padding-left: 0; padding-right: 0; margin-top: 20px;">
                        @if(count($results) > 0)
                            <button class="btn btn-primary pull-right" id="export" type="button">
                                <span class="glyphicon glyphicon-export"></span>
                                {{ trans('messages.export_excel') }}
                            </button>
                        @endif
                    </div>
                </div>


            @else
                <div class="alert alert-warning text-center">
                    <strong>{{trans('messages.data_not_found')}}</strong>
                </div>
            @endif
        </div>
        <input type="hidden" id="btn_close" value="{{trans('messages.btn_close')}}">
    </div>
@endsection
@push('scripts')
<link href="{{url('css/view-backend/reports.css')}}" type="text/css" rel="stylesheet">
<link href="{{url('bootstrap-select/css/bootstrap-select.min.css')}}" type="text/css" rel="stylesheet">
<script src="{{url('bootstrap-select/js/bootstrap-select.min.js')}}"></script>
<script src="{{url('jquery-plugin-for-bootstrap-loading-modal/build/bootstrap-waitingfor.js')}}"></script>
<script>
    $("#export").click(function () {
        var type_sale_buy = $('#type_sale_buy option:selected').val()
        var user_id = $('#user option:selected').val()
        var key_token = $('input[name=_token]').val();
        waitingDialog.show('<?php echo trans('messages.text_loading_lease_wait')?>', {
            //headerText: 'jQueryScript',
            //dialogSize: 'sm',
            progressType: 'success'
        });
        $.ajax({
            headers: {'X-CSRF-TOKEN': key_token},
            type: "POST",
            url: "<?php echo url('admin/reports/order-history-sale-buy/export')?>",
            data: {type_sale_buy: type_sale_buy, user_id: user_id},
            success: function (response) {
                $('.modal-content').empty();
                $('.modal-content').html('<div class="modal-body text-center"><button class="btn btn-info a-download" id="btn-download" style="margin-right: 5px;"><?php echo trans('messages.text_download')?></button><button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo trans('messages.text_close')?></button></div>');
                $(".a-download").click(function () {
                    waitingDialog.hide();
                    window.open(
                        "<?php echo url('admin/reports/shop/download/?file=')?>" + response.file,
                        '_blank'
                    );
                });
                return false;
            },
            error: function (response) {
                alert('error..');
                return false;
            }
        })
    });
</script>
@endpush
