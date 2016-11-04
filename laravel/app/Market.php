<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    protected $table = "markets";
    public $fillable = ['market_title_th',
                        'market_title_en',
                        'market_description_th',
                        'market_description_en',
                        'marketimage_file',
                        'sequence'];

}
?>
