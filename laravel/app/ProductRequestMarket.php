<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductRequestMarket extends Model
{
    protected $table = "product_request_market";
    protected $fillable = ['product_request_id', 'market_id'];
    public $timestamps = false;
}
