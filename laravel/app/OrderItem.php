<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = "order_items";

    public $fillable = ['order_id',
        'product_id',
        'unit_price',
        'quantity',
        'discount',
        'total',
        'order_item_status'];


    public function order(){
        return $this->belongsTo('App\Order');
    }
}
