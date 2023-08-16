<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookCategoryRelation extends Model
{
    use HasFactory;
    protected $fillable = [
        'book_category_id',
        'book_id',
    ];
}
