<?php

namespace Domain\Travelcategory\ViewModels;

use App\Models\Travelcategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Support\Traits\Makeable;

class TravelcategoryViewModel
{
    use Makeable;

    public function categoriesOfCountry(int $siteId, int $countryId, int $perPage = 20): LengthAwarePaginator
    {
        return Travelcategory::query()
            ->published()
            ->ofSite($siteId)
            ->ofCountry($countryId)
            ->ordered()
            ->paginate($perPage);
    }

    public function oneCategory(int $siteId, string $slug): ?Travelcategory
    {
        return Travelcategory::query()
            ->published()
            ->ofSite($siteId)
            ->bySlug($slug)
            ->first();
    }
}
