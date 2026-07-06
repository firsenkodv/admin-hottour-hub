<?php

namespace App\Models;

use Domain\Country\QueryBuilders\CountryQueryBuilder;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'title', 'slug', 'image', 'smalltext', 'text', 'published', 'sorting',
    'metatitle', 'description', 'keywords',
])]
class Country extends Model
{
    protected function casts(): array
    {
        return [
            'published' => 'boolean',
        ];
    }

    public function hotels(): HasMany
    {
        return $this->hasMany(Hotel::class);
    }

    public function siteContents(): HasMany
    {
        return $this->hasMany(CountrySiteContent::class);
    }

    public function newEloquentBuilder($query): CountryQueryBuilder
    {
        return new CountryQueryBuilder($query);
    }
}
