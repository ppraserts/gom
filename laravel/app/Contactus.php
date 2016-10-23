<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $table = "contactus";
    public $fillable = ['contactus_address_th',
                        'contactus_address_en',
                        'contactus_latitude',
                        'contactus_longitude'];

}
?>
