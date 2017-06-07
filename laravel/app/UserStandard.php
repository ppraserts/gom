<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStandard extends Model
{
    protected $table = "user_standard";
    protected $fillable = ['user_id', 'standard_id'];
    public $timestamps = false;

}
