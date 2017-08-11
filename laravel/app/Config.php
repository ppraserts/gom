<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    public $timestamps = false;
    protected $table = "config";
    public $fillable = ['censor_word'];
}
