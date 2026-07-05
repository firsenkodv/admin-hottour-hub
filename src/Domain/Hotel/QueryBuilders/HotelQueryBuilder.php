<?php

namespace Domain\Hotel\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class HotelQueryBuilder extends Builder
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

    public function ofCountry(int $countryId): static
    {
        return $this->where('country_id', $countryId);
    }
}
