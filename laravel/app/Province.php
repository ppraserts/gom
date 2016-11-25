<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = "province";
    public $fillable = ['PROVINCE_ID',
                        'PROVINCE_CODE',
                        'PROVINCE_NAME',
                        'GEO_ID'];

}
?>
