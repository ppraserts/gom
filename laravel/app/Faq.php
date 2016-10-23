<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = "faq";
    public $fillable = ['faq_question_th',
                        'faq_question_en',
                        'faq_answer_th',
                        'faq_answer_en',
                        'faqcategory_id',
                        'sequence'];

}
?>
