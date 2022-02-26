<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'ar_name',
    'en_name',
    'language_id',
    'category_id',
    'image',
    'order',
    'status',
    ];

    public function category(){
        return $this->belongsTo('App\Models\Category','category_id');
      }
      public function language(){
        return $this->belongsTo('App\Models\Language','language_id');
      }
}
