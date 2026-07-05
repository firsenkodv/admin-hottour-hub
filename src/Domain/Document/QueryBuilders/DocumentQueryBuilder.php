<?php

namespace Domain\Document\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class DocumentQueryBuilder extends Builder
{
    public function published(): static
    {
        return $this->where('published', true);
    }

    public function ordered(): static
    {
        return $this->orderBy('sorting');
    }

    public function bySlug(string $slug): static
    {
        return $this->where('slug', $slug);
    }

    public function ofSite(int $siteId): static
    {
        return $this->where('site_id', $siteId);
    }
}
