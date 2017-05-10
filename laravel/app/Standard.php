<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Standard extends Model
{
    //
    protected $table = "standards";
    public $fillable = ['name'];

    public function productRequests(){
        return $this->belongsToMany( 'App\ProductRequest' );
    }
}
