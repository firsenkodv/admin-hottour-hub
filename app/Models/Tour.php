<?php

namespace App\Models;

use Domain\Tour\QueryBuilders\TourQueryBuilder;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'site_id', 'country_id', 'title', 'slug', 'image', 'gallery', 'price', 'nights',
    'smalltext', 'text', 'published', 'sorting',
    'metatitle', 'description', 'keywords',
])]
class Tour extends Model
{
    protected function casts(): array
    {
        return [
            'published' => 'boolean',
            'gallery' => 'collection',
            'price' => 'float',
        ];
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function newEloquentBuilder($query): TourQueryBuilder
    {
        return new TourQueryBuilder($query);
    }
}
