<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PormotionRecomment extends Model
{
    protected $table = "promotion_recommends";

    public $fillable = ['id',
        'promotion_id',
        'recommend_date',
        'email',
        'detail',
        'count_recommend'];

}
