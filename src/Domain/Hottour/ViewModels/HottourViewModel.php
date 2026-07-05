<?php

namespace Domain\Hottour\ViewModels;

use App\Models\Hottour;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Support\Traits\Makeable;

class HottourViewModel
{
    use Makeable;

    public function hottoursOfSite(int $siteId, int $perPage = 20): LengthAwarePaginator
    {
        return Hottour::query()
            ->published()
            ->active()
            ->ofSite($siteId)
            ->ordered()
            ->paginate($perPage);
    }

    public function oneHottour(int $siteId, string $slug): ?Hottour
    {
        return Hottour::query()
            ->published()
            ->ofSite($siteId)
            ->bySlug($slug)
            ->first();
    }
}
