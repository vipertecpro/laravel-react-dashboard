<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookReview extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'content',
        'rating',
        'status',
        'created_by',
        'book_id',
    ];
}
