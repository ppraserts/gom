<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BadWord extends Model
{
    public $timestamps = false;
    protected $table = "bad_words";
    public $fillable = ['id',
        'bad_word'];
}
