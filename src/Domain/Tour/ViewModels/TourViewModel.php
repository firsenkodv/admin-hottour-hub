<?php

namespace Domain\Tour\ViewModels;

use App\Models\Tour;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Support\Traits\Makeable;

class TourViewModel
{
    use Makeable;

    public function toursOfCountry(int $siteId, int $countryId, int $perPage = 20): LengthAwarePaginator
    {
        return Tour::query()
            ->published()
            ->ofSite($siteId)
            ->ofCountry($countryId)
            ->ordered()
            ->paginate($perPage);
    }

    public function oneTour(int $siteId, string $slug): ?Tour
    {
        return Tour::query()
            ->published()
            ->ofSite($siteId)
            ->bySlug($slug)
            ->first();
    }
}
