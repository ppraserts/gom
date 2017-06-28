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
            <h4>{{ trans('messages.text_report_menu_order_status_history') }}</h4>
            <form action="{{url('admin/reports/orders')}}" method="GET">
                <div class="input-group custom-search-form">
                    <input type="text" id="search" name="filter" class="form-control" value="{{Request::input('filter')}}"
                           placeholder="{{ trans('messages.order_id').'/'.trans('messages.i_sale').'/'.trans('messages.order_status') }}">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="submit">
                          <i class="fa fa-search"></i>
                      </button>
                  </span>
                </div>
            </form>
        </div>

        <div class="row" style="margin-top: 10px">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th width="120px" style="text-align:center;">{{ trans('messages.order_id') }}</th>
                        <th style="text-align:center;">{{ trans('messages.order_type') }}</th>
                        <th>{{ trans('messages.i_sale') }}</th>
                        <th>{{ trans('messages.i_buy') }}</th>
                        <th style="text-align:center;">{{ trans('messages.order_date') }}</th>
                        <th style="text-align:center;">{{ trans('messages.order_total') }}</th>
                        <th style="text-align:center;">{{ trans('messages.order_status') }}</th>
                        <th width="130px" style="text-align:center;">
                            {{ trans('messages.view_order_detail') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($results) > 0 )
                    @foreach ($results as $result)
                        <tr>
                            <td style="text-align:center;">{{ $result->id }}</td>
                            <td style="text-align:center;">
                                {{ $result->order_type== 'retail'? trans('messages.retail'): trans('messages.wholesale')}}
                            </td>
                            <td>{{ $result->users_firstname_th. " ". $result->users_lastname_th }}</td>
                            <th style="font-weight: normal">
                                {{ $result->buyer->users_firstname_th. " ". $result->buyer->users_lastname_th }}
                            </th>
                            <td style="text-align:center;">{{ $result->order_date }}</td>
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
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        @if(count($results) > 0 )
        <div class="row">
            <div class="col-md-12">{!! $results->appends(Request::all()) !!}</div>
        </div>
        @endif
    </div>
@endsection

@push('scripts')
<link href="{{url('css/view-backend/reports.css')}}" type="text/css" rel="stylesheet">
@endpush
