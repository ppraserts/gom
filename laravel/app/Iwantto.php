<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Iwantto extends Model
{
    protected $table = "iwantto";
    public $fillable = ['iwantto',
                        'product_title',
                        'product_description',
                        'guarantee',
                        'price',
                        'is_showprice',
                        'volumn',
                        'product1_file',
                        'product2_file',
                        'product3_file',
                        'productstatus',
                        'pricerange_start',
                        'pricerange_end',
                        'volumnrange_start',
                        'volumnrange_end',
                        'units',
                        'city',
                        'province',
                        'productcategorys_id',
                        'products_id',
                        'users_id',
                        ];

}
?>
