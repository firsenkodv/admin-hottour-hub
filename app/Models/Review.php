<?php

namespace App\Models;

use Domain\Review\QueryBuilders\ReviewQueryBuilder;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['hotel_id', 'author_name', 'rating', 'text', 'published', 'sorting'])]
class Review extends Model
{
    protected function casts(): array
    {
        return [
            'published' => 'boolean',
        ];
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function newEloquentBuilder($query): ReviewQueryBuilder
    {
        return new ReviewQueryBuilder($query);
    }
}
