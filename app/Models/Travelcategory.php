<?php

namespace App\Models;

use Domain\Travelcategory\QueryBuilders\TravelcategoryQueryBuilder;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'site_id', 'country_id', 'title', 'slug', 'image', 'smalltext', 'text', 'published', 'sorting',
    'metatitle', 'description', 'keywords',
])]
class Travelcategory extends Model
{
    protected function casts(): array
    {
        return [
            'published' => 'boolean',
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

    public function items(): HasMany
    {
        return $this->hasMany(Travelitem::class);
    }

    public function newEloquentBuilder($query): TravelcategoryQueryBuilder
    {
        return new TravelcategoryQueryBuilder($query);
    }
}
