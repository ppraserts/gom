<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDelivery extends Model
{
    protected $table = "order_delivery";
    public $fillable = ['user_buy_id',
        'user_sale_id',
        'order_id',
        'shipping_channel',
        'delivery_charge',
        'sum_delivery_charge'];
}
