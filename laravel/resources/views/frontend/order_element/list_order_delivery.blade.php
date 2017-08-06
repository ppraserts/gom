@if(count($orderDeliverys) > 0)
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <h3>ข้อมูลการจัดส่ง</h3>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <th style="text-align:center;">เลือก</th>
                            <th style="text-align:center;">ช่องทางการจัดส่ง</th>
                            <th style="text-align:center;">ค่าจัดส่ง (บาท)</th>
                            <th style="text-align:center;">ยอดสุทธิ (ค่าสินค้า + ค่าจัดส่ง)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($orderDeliverys as $orderDelivery)
                            <tr>
                                <td style="text-align:center;"><input type="checkbox" @if($orderDelivery->selected == 1)checked @endif disabled></td>
                                <td style="text-align:center;">{{$orderDelivery->shipping_channel}}</td>
                                <td style="text-align:left; max-width: 400px;">{{$orderDelivery->delivery_charge}}</td>
                                <td style="text-align:left; max-width: 400px;">{{$orderDelivery->sum_delivery_charge}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif