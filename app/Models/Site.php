<?php

namespace App\Models;

use Domain\Site\QueryBuilders\SiteQueryBuilder;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['code', 'title', 'domain', 'api_base_url', 'api_key', 'api_secret', 'is_active', 'last_synced_at'])]
#[Hidden(['api_secret'])]
class Site extends Model
{
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'last_synced_at' => 'datetime',
        ];
    }

    public function newEloquentBuilder($query): SiteQueryBuilder
    {
        return new SiteQueryBuilder($query);
    }
}
