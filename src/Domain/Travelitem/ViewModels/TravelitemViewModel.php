<?php

namespace Domain\Travelitem\ViewModels;

use App\Models\Travelitem;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Support\Traits\Makeable;

class TravelitemViewModel
{
    use Makeable;

    public function itemsOfCategory(int $siteId, int $categoryId, int $perPage = 20): LengthAwarePaginator
    {
        return Travelitem::query()
            ->published()
            ->ofSite($siteId)
            ->ofCategory($categoryId)
            ->ordered()
            ->paginate($perPage);
    }

    public function oneItem(int $siteId, string $slug): ?Travelitem
    {
        return Travelitem::query()
            ->published()
            ->ofSite($siteId)
            ->bySlug($slug)
            ->first();
    }
}
