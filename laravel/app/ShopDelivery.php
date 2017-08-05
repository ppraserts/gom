<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopDelivery extends Model
{
    protected $table = "shop_delivery";
    protected $fillable = ['shop_id', 'delivery_name','delivery_price'];
    public $timestamps = false;
}
