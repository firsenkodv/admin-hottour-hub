<?php

namespace App\Models;

use Domain\Travelitem\QueryBuilders\TravelitemQueryBuilder;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'site_id', 'travelcategory_id', 'title', 'slug', 'image', 'smalltext', 'text', 'published', 'sorting',
    'metatitle', 'description', 'keywords',
])]
class Travelitem extends Model
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

    public function travelcategory(): BelongsTo
    {
        return $this->belongsTo(Travelcategory::class);
    }

    public function newEloquentBuilder($query): TravelitemQueryBuilder
    {
        return new TravelitemQueryBuilder($query);
    }
}
