<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'icon_file_path',
        'name',
        'slug',
        'description',
        'parent_id',
        'is_active',
    ];
}
