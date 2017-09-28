<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotions extends Model
{
    public $timestamps = false;
    protected $table = "promotions";
    public $fillable = ['shop_id',
        'promotion_title',
        'promotion_description',
        'image_file',
        'start_date',
        'end_date',
        'sequence',
        'is_active'];


}
