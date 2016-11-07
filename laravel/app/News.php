<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = "news";
    public $fillable = ['news_title_th',
    	           'news_description_th',
                        'news_title_en',
                        'news_description_en',
                        'news_created_at',
                        'news_place',
                        'news_tags',
                        'news_sponsor',
                        'news_document_file',
                        'sequence'];

}
?>
