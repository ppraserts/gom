<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Units extends Model
{
    protected $table = "units";
    public $fillable = ['units_th',
                        'units_en',
                        'sequence'];

}
?>
