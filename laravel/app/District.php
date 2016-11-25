<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = "district";
    public $fillable = ['DISTRICT_ID',
                        'DISTRICT_CODE',
                        'DISTRICT_NAME',
                        'AMPHUR_ID',
                        'PROVINCE_ID',
                        'GEO_ID'];

}
?>
