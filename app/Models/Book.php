<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'title',
        'slug',
        'ISBN_10',
        'ISBN_13',
        'author',
        'created_by',
    ];
    public function bookReviews(): HasMany
    {
        return $this->hasMany(BookReview::class)->with(['createdBy']);
    }
    public function getBookReviewsAvgRatingAttribute($value): string
    {
        $rating = round($value);
        return "{$rating}/5";
    }
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class,'created_by');
    }
    public function getCreatedAtAttribute($date): string
    {
        return Carbon::parse($date)->format('d-m-y H:i:s');
    }
}
