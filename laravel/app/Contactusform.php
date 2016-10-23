<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactUsForm extends Model
{
    protected $table = "contactusform";
    public $fillable = ['contactusform_name',
                        'contactusform_surname',
                        'contactusform_email',
                        'contactusform_phone',
                        'contactusform_file',
                        'contactusform_subject',
                        'contactusform_messagebox'];

}
?>
