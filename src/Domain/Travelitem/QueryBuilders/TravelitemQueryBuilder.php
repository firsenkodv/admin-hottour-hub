<?php

namespace Domain\Travelitem\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class TravelitemQueryBuilder extends Builder
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

    public function ofCategory(int $categoryId): static
    {
        return $this->where('travelcategory_id', $categoryId);
    }
}
