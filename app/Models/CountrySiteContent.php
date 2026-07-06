<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['country_id', 'site_id', 'title', 'smalltext', 'text', 'metatitle', 'description', 'keywords'])]
class CountrySiteContent extends Model
{
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
