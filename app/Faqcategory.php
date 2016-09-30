<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    protected $table = "FaqCategorys";
    public $fillable = ['faqcategory_title_th',
                        'faqcategory_title_en',
                        'faqcategory_description_th',
                        'faqcategory_description_en',
                        'sequence'];

}
?>
