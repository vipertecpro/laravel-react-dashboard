<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class,'created_by')->select(['id','name']);
    }
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class,'book_id');
    }
    public function getCreatedAtAttribute($date): string
    {
        return Carbon::parse($date)->format('d-m-y H:i:s');
    }
}
