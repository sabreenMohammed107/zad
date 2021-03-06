<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'language_id',
        'category_id',
        'sub_category_id',
        'image',
        'question',
        'question_type',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'option_e',
        'answer',
        'level_id',
        'notes',
        'quiz_id',
        'quiz_type'
    ];
    public function category(){
        return $this->belongsTo('App\Models\Category','category_id');
      }
      public function language(){
        return $this->belongsTo('App\Models\Language','language_id');
      }
      public function sub_category(){
        return $this->belongsTo('App\Models\Subcategory','sub_category_id');
      }
}
