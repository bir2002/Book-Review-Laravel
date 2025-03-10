<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class review extends Model
{
    use Hasfactory;

    protected $fillable = [
    'book_id',
        'review',
        'rating',
    ];

    public function book ()
    {
        return $this->belongsTo(Book::class);
    }

    protected static function booted()
    {
        static::updated(
            fn (Review $review) => cache()->forget('book:' . $review->book_id)
        );
        static::deleted(
            fn (Review $review) => cache()->forget('book:' . $review->book_id)
        );
    }
}
