<?php

namespace App\Models;

use Domain\Hottour\QueryBuilders\HottourQueryBuilder;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'site_id', 'country_id', 'hotel_id', 'title', 'slug', 'image', 'price', 'old_price', 'nights', 'valid_until',
    'smalltext', 'text', 'published', 'sorting',
    'metatitle', 'description', 'keywords',
])]
class Hottour extends Model
{
    protected function casts(): array
    {
        return [
            'published' => 'boolean',
            'price' => 'float',
            'old_price' => 'float',
            'valid_until' => 'date',
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

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function newEloquentBuilder($query): HottourQueryBuilder
    {
        return new HottourQueryBuilder($query);
    }
}
