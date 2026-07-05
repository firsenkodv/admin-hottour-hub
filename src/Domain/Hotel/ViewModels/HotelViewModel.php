<?php

namespace Domain\Hotel\ViewModels;

use App\Models\Hotel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Support\Traits\Makeable;

class HotelViewModel
{
    use Makeable;

    public function hotelsOfCountry(int $countryId, int $perPage = 20): LengthAwarePaginator
    {
        return Hotel::query()
            ->published()
            ->ofCountry($countryId)
            ->ordered()
            ->paginate($perPage);
    }

    public function oneHotel(string $slug): ?Hotel
    {
        return Hotel::query()
            ->published()
            ->bySlug($slug)
            ->first();
    }
}
