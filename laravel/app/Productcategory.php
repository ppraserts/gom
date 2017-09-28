<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = "productcategorys";
    public $fillable = ['productcategory_title_th',
                        'productcategory_title_en',
                        'productcategory_description_th',
                        'productcategory_description_en',
                        'sequence'];

    public function product()
    {
        return $this->hasMany('App\Product');
    }

}
?>
