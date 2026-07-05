<?php

namespace App\Models;

use Domain\Hotel\QueryBuilders\HotelQueryBuilder;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'country_id', 'title', 'slug', 'stars', 'rating', 'image', 'gallery',
    'smalltext', 'text', 'published', 'sorting',
    'metatitle', 'description', 'keywords',
])]
class Hotel extends Model
{
    protected function casts(): array
    {
        return [
            'published' => 'boolean',
            'gallery' => 'collection',
            'rating' => 'float',
        ];
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function newEloquentBuilder($query): HotelQueryBuilder
    {
        return new HotelQueryBuilder($query);
    }
}
