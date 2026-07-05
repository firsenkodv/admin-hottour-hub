<?php

namespace App\Models;

use Domain\Contact\QueryBuilders\ContactQueryBuilder;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['site_id', 'phone', 'email', 'address', 'working_hours', 'map_embed', 'text'])]
class Contact extends Model
{
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function newEloquentBuilder($query): ContactQueryBuilder
    {
        return new ContactQueryBuilder($query);
    }
}
