<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Standard extends Model
{
    //
    protected $table = "standards";
    public $fillable = ['name'];

    public function users(){
        return $this->belongsToMany( 'App\Model\frontend\User' );
    }
}
