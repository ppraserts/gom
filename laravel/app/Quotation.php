<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    //
    protected $table = "quotation";

    public $fillable = ['price',
        'discount',
        'is_reply',
        'remark'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id','user_id');
    }

    public function productRequest()
    {
        return $this->belongsTo('App\ProductRequest', 'product_request_id');
    }

}
