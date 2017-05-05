<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";
    public $fillable = ['product_name_th',
        'product_name_en',
        'productcategory_id',
        'user_id',
        'sequence'];

    public function productCategory()
    {
        return $this->belongsTo('App\ProductCategory', 'productcategory_id');
    }

    public function productOrderItem()
    {
        return $this->hasMany('App\OrderItem', 'product_id', 'id');
    }

    public function productRequest()
    {
        return $this->hasMany('App\ProductRequest', 'products_id', 'id');
    }

}

?>
