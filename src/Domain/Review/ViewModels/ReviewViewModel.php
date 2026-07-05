<?php

namespace Domain\Review\ViewModels;

use App\Models\Review;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Support\Traits\Makeable;

class ReviewViewModel
{
    use Makeable;

    public function listReviews(int $perPage = 20): LengthAwarePaginator
    {
        return Review::query()
            ->published()
            ->ordered()
            ->paginate($perPage);
    }

    public function reviewsOfHotel(int $hotelId, int $perPage = 20): LengthAwarePaginator
    {
        return Review::query()
            ->published()
            ->ofHotel($hotelId)
            ->ordered()
            ->paginate($perPage);
    }
}
