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
            <form action="{{url('admin/reports/shop')}}" class="form-horizontal" id="my-form" method="POST">
                {{csrf_field()}}
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
                <button class="btn btn-primary pull-right" id="export" type="button">
                    <span class="glyphicon glyphicon-export" aria-hidden="true"></span> {{ trans('messages.text_export') }}
                </button>
                {!! $results->appends(Request::all()) !!}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<link href="{{url('css/view-backend/reports.css')}}" type="text/css" rel="stylesheet">
<link href="{{url('bootstrap-select/css/bootstrap-select.min.css')}}" type="text/css" rel="stylesheet">
<script src="{{url('bootstrap-select/js/bootstrap-select.min.js')}}"></script>
<script type="text/javascript">
    $(function () {
        $('#my-form').submit(function () {
            var shop = $("#shop option:selected").val();
            if (!shop) {
                $("#shop").focus();
                $("#ms_shop").html('<?php echo Lang::get('validation.attributes.message_validate_shop')?>');
                return false;
            } else {
                $("#ms_shop").html('');
            }
        });
    });

    //***********************************************
    $("#export").click(function () {

        var shop_id = [];
        $('#shop option:selected').each(function (i, selected) {
            shop_id[i] = $(selected).val();
        });
        var key_token = $('input[name=_token]').val();
        $.ajax({
            headers: {'X-CSRF-TOKEN': key_token},
            type: "POST",
            url: "<?php $page = ''; if (!empty(Request::input('page'))) {
                $page = '?page=' . Request::input('page');
            } echo url('admin/reports/shop/export' . $page)?>",
            data: { shop_id_arr: shop_id},
            success: function (response) {
                window.open(
                    "<?php echo url('admin/reports/shop/download/?file=')?>" + response.file,
                    '_blank'
                );
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
