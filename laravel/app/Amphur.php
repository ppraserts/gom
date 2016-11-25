<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Amphur extends Model
{
    protected $table = "amphur";
    public $fillable = ['AMPHUR_ID',
                        'AMPHUR_CODE',
                        'AMPHUR_NAME',
                        'GEO_ID',
                        'PROVINCE_ID'];

}
?>
