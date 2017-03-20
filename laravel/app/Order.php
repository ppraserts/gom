<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = "orders";

    public $fillable = ['user_id',
                        'order_date',
                        'order_status',
                        'total_amount',
                        'order_type'];

    public function orderItems(){
        return $this->hasMany('App\OrderItem');
    }

}
