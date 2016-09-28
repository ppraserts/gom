<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    protected $table = "AboutUs";
    public $fillable = ['aboutus_description_th',
                        'aboutus_description_en'];

}
?>
