<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";
    public $fillable = ['product_name_th',
                        'product_name_en',
                        'productcategory_id',
                        'sequence'];

}
?>
