<?php

namespace Domain\Country\ViewModels;

use App\Models\Country;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Support\Traits\Makeable;

class CountryViewModel
{
    use Makeable;

    public function listCountries(int $perPage = 20): LengthAwarePaginator
    {
        return Country::query()
            ->published()
            ->ordered()
            ->paginate($perPage);
    }

    public function oneCountry(string $slug): ?Country
    {
        return Country::query()
            ->published()
            ->bySlug($slug)
            ->first();
    }
}
