<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class DownloadDocument extends Model
{
    protected $table = "DownloadDocuments";
    public $fillable = ['downloaddocument_title_th',
                        'downloaddocument_title_en',
                        'downloaddocument_description_th',
                        'downloaddocument_description_en',
                        'downloaddocument_file',
                        'sequence'];

}
?>
