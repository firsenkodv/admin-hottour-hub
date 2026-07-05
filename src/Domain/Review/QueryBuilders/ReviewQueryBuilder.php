<?php

namespace Domain\Review\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class ReviewQueryBuilder extends Builder
{
    public function published(): static
    {
        return $this->where('published', true);
    }

    public function ordered(): static
    {
        return $this->orderBy('sorting');
    }

    public function ofHotel(int $hotelId): static
    {
        return $this->where('hotel_id', $hotelId);
    }
}
