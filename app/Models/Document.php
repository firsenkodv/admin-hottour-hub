<?php

namespace App\Models;

use Domain\Document\QueryBuilders\DocumentQueryBuilder;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['site_id', 'title', 'slug', 'file', 'description', 'published', 'sorting'])]
class Document extends Model
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

    public function newEloquentBuilder($query): DocumentQueryBuilder
    {
        return new DocumentQueryBuilder($query);
    }
}
