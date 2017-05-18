<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = "orders";

    public $fillable = ['order_date',
                        'order_status',
                        'total_amount',
                        'grand_amount'];

    public function orders_items(){
        return $this->hasMany('App\OrderItem');
    }

}
