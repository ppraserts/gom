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
        <div class="row">
            <h4>{{ trans('messages.text_report_menu_shop') }} :</h4>
            {{csrf_field()}}
            <form action="{{url('admin/reports/shop')}}" class="form-horizontal" id="my-form" method="GET">
                <input type="hidden" name="is_search" value="true">
                <div class="form-group form-group-sm col-md-11" style="padding-left: 0px; padding-right: 0;">
                    <label class="col-sm-1" style="padding-right: 0; padding-left: 0;">
                        * {{ trans('messages.shop') }} :
                    </label>
                    <div class='col-sm-11' style="padding-right: 0;">
                        <select class="selectpicker form-control" name="shop[]" id="shop"
                                data-live-search="true"
                                multiple>
                            @if(count($shops))
                                @foreach($shops as $shop)
                                    <option value="{{$shop->id}}" @if(!empty($shopArr)) @if(in_array($shop->id, $shopArr)) selected @endif @endif>
                                        {{$shop->shop_name}}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <small class="alert-danger" id="ms_shop"></small>
                    </div>
                </div>
                <div class="col-md-1" style="padding-left: 0; padding-right: 0;">
                    <button class="btn btn-primary pull-right btn-sm" type="submit">
                        <i class="fa fa-search"></i> {{ trans('messages.search') }}
                    </button>
                </div>
            </form>

        </div>
        <div class="row" style="margin-top: 10px">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th width="120px" style="text-align:center;">{{ trans('messages.text_shop_id') }}</th>
                        <th>{{ trans('messages.text_shop_url') }}</th>
                        <th style="text-align:center;">{{ trans('messages.text_shop_title') }}</th>
                        <th style="text-align:center;">{{ trans('messages.text_shop_score') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($results as $result)
                        <tr>
                            <td style="text-align:center;">{{ $result->id }}</td>
                            <td><a href="{{ url($result->shop_name) }}" target="_blank">{{ url($result->shop_name) }}</a>  </td>
                            <td>{{ $result->shop_title }}</td>
                            <td>
                                @if(!empty($result->shop_score)){{ $result->shop_score }} @else 0 @endif
                                {{ trans('messages.text_star') }}
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">{!! $results->appends(Request::all()) !!}</div>
            <div class="col-md-6 text-right">
                @if(count($results) > 0)
                <button class="btn btn-primary pull-right" id="export" type="button">
                    <span class="glyphicon glyphicon-export"></span>
                    {{ trans('messages.export_excel') }}
                </button>
                @endif
            </div>
        </div>
        <input type="hidden" id="btn_close" value="{{trans('messages.btn_close')}}">
    </div>
@endsection

@push('scripts')
<link href="{{url('css/view-backend/reports.css')}}" type="text/css" rel="stylesheet">
<link href="{{url('bootstrap-select/css/bootstrap-select.min.css')}}" type="text/css" rel="stylesheet">
<script src="{{url('bootstrap-select/js/bootstrap-select.min.js')}}"></script>
<script src="{{url('jquery-plugin-for-bootstrap-loading-modal/build/bootstrap-waitingfor.js')}}"></script>
<script type="text/javascript">
    $("#export").click(function () {
        var shop_id = [];
        $('#shop option:selected').each(function (i, selected) {
            shop_id[i] = $(selected).val();
        });
        var key_token = $('input[name=_token]').val();
        waitingDialog.show('<?php echo trans('messages.text_loading_lease_wait')?>', {
            progressType: 'success'
        });

        $.ajax({
            headers: {'X-CSRF-TOKEN': key_token},
            type: "POST",
            url: "<?php $page = ''; if (!empty(Request::input('page'))) {
                $page = '?page=' . Request::input('page');
            } echo url('admin/reports/shop/export' . $page)?>",
            data: { shop_id_arr: shop_id},
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
