<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = "ProductCategorys";
    public $fillable = ['productcategory_title_th',
                        'productcategory_title_en',
                        'productcategory_description_th',
                        'productcategory_description_en',
                        'sequence'];

}
?>
