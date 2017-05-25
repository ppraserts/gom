<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "comments";
    public $fillable = ['id',
        'shop_id',
        'product_id',
        'score',
        'comment'];
}
