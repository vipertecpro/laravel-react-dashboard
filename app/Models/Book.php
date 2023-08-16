<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'title',
        'subtitle',
        'slug',
        'description',
        'ISBN_10',
        'ISBN_13',
        'price',
        'author_id',
        'publisher_id',
        'stock_quantity',
        'status',
        'weight',
        'width',
        'height',
        'depth',
        'language',
        'publication_date',
        'is_preorder',
        'binding_type',
        'attachment_id',
        'number_of_pages',
        'created_by',
    ];
}
