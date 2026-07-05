<?php

namespace Domain\Hottour\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class HottourQueryBuilder extends Builder
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

    public function ofCountry(int $countryId): static
    {
        return $this->where('country_id', $countryId);
    }

    public function active(): static
    {
        return $this->where(function ($query) {
            $query->whereNull('valid_until')
                ->orWhereDate('valid_until', '>=', now());
        });
    }
}
