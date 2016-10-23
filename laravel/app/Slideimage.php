<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class SlideImage extends Model
{
    protected $table = "slideimages";
    public $fillable = ['slideimage_name',
                        'slideimage_file',
                        'slideimage_type',
                        'slideimage_urllink',
                        'sequence'];

}
?>
