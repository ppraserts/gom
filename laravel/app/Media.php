<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = "medias";
    public $fillable = ['media_name_th',
                        'media_name_en',
                        'media_urllink',
                        'sequence'];

}
?>
