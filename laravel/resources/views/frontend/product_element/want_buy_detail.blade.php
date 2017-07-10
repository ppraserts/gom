<div class="col-md-8" style="background-color:#FFFFFF; padding:20px;">
    <h2>ต้องการซื้อ</h2>
    <div class="row">
        <div class="price col-md-12">
            <h4 title="{{ $productRequest->product_name_th }}"><?php echo mb_strimwidth($productRequest->product_name_th, 0, 40, '...', 'UTF-8'); ?></h4>
            <span class="glyphicon glyphicon-map-marker"></span>
            {{ mb_strimwidth($productRequest->city ." ".$productRequest->province, 0, 40, '...', 'UTF-8') }}
            <br/><br/>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <p>
                <span class="hidden-sm">  {{ trans('messages.unit_price'). " ".floatval($productRequest->pricerange_start)."-".floatval($productRequest->pricerange_end). trans('messages.baht')." / ". $productRequest->units }}</span>
            </p>
        </div>
    </div>
</div>
