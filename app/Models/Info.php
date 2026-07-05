<?php

namespace App\Models;

use Domain\Info\QueryBuilders\InfoQueryBuilder;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'site_id', 'title', 'image', 'smalltext', 'text',
    'metatitle', 'description', 'keywords',
])]
class Info extends Model
{
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function newEloquentBuilder($query): InfoQueryBuilder
    {
        return new InfoQueryBuilder($query);
    }
}
