<?php

namespace Domain\Country\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class CountryQueryBuilder extends Builder
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
}
