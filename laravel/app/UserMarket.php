<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMarket extends Model
{
    protected $table = "user_market";
    protected $fillable = ['user_id', 'market_id'];
    public $timestamps = false;
}