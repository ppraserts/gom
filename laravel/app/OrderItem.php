<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

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


    public function order()
    {
        return $this->belongsTo('App\Order','order_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Product','product_id');
    }

    public function orderItemDetail($order_id)
    {
        $sql = 'SELECT o.* 
            ,p.product_name_th
            ,pr.units
            ,pr.price 
            FROM order_items o INNER JOIN products p  ON o.product_id = p.id INNER JOIN  product_requests pr ON p.id = pr.products_id WHERE o.order_id = ' . $order_id;
        return DB::select(DB::raw($sql));
    }

}
