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
}
