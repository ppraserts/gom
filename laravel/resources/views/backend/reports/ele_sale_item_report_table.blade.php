<div class="row" style="margin-top: 10px">
    @if(count($orderSaleItem) > 0 && count($errors) <1)
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th width="120px" style="text-align:center;">{{ trans('messages.order_id') }}</th>
                    <th style="text-align:center;">{{ trans('messages.order_sale_date') }}</th>
                    <th style="text-align:center;">{{ trans('messages.order_type') }}</th>
                    <th style="text-align:center;">{{ trans('messages.menu_market') }}</th>
                    <th style="text-align:center;">{{ trans('messages.menu_add_product') }}</th>
                    <th>{{ trans('messages.orderbyunit') }}</th>
                    <th>{{ trans('messages.i_sale') }}</th>
                    <th>{{ trans('messages.i_buy') }}</th>
                    <th style="text-align:center; min-width: 70px;">{{ trans('messages.order_total')}} <br/> {{'('.trans('messages.baht').')' }}</th>
                    <th style="text-align:center;">{{ trans('messages.order_status') }}</th>
                    <th width="130px" style="text-align:center;">
                        {{ trans('messages.view_order_detail') }}
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orderSaleItem as $item)
                    <tr>
                        <td style="text-align:center;">{{ $item->id }}</td>
                        <td style="text-align:center;">{{ \App\Helpers\DateFuncs::mysqlToThaiDate($item->order_date) }}</td>
                        <td>
                            @if($item->order_type== 'retail')
                                {{trans('messages.retail')}}
                            @else
                                {{trans('messages.wholesale')}}
                            @endif
                        </td>
                        <td>{{ $item->market_title_th }}</td>
                        <td>{{ $item->product_name_th }}</td>
                        <td>{{ $item->quantity.' '.$item->units }}</td>

                        <td>{{ $item->users_firstname_th. " ". $item->users_lastname_th }}</td>
                        <th style="font-weight: normal">
                            {{ $item->buyer->users_firstname_th. " ". $item->buyer->users_lastname_th }}
                        </th>
                        {{--$item->total_amount--}}
                        <td style="text-align:center;">{{ $item->total }}</td>
                        <td style="text-align:center;">{{ $item->status_name }}</td>
                        <td style="text-align:center;">
                            <a class="btn btn-primary"
                               href="{{ url ('user/orderdetail/'.$item->id) }}">
                                <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    @else
        <div class="alert alert-warning text-center">
            <strong>{{trans('messages.data_not_found')}}</strong>
        </div>
    @endif
</div>
@if(count($orderSaleItem) > 0)
    <div class="row">
        <div class="col-md-6">{!! $orderSaleItem->appends(Request::all()) !!}</div>
        <div class="col-md-6">
            <div class="col-md-12" style="padding-left: 0; padding-right: 0; margin-top: 20px;">
                <button class="btn btn-primary pull-right" id="export" type="button">
                    <span class="glyphicon glyphicon-export"></span>
                    {{ trans('messages.export_excel') }}
                </button>
            </div>
        </div>
    </div>
@endif