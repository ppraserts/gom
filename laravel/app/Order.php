<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = "orders";

    public $fillable = ['user_id',
                        'buyer_id',
                        'order_date',
                        'order_status',
                        'total_amount',
                        'order_type'];

    public function orderItems(){
        return $this->hasMany('App\OrderItem');
    }

    public function orderStatusName(){
        return $this->belongsTo('App\OrderStatus','order_status');
    }

    public function user(){
        return$this->hasOne('App\User','id','user_id');
    }

    public function buyer(){
        return$this->hasOne('App\User','id','buyer_id');
    }

}
