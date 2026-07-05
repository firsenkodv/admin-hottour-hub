<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Domain\Country\ViewModels\CountryViewModel;
use Domain\Hotel\ViewModels\HotelViewModel;
use Illuminate\Contracts\View\View;

class CountryController extends Controller
{
    public function index(CountryViewModel $countries): View
    {
        return view('pages.countries.index', [
            'countries' => $countries->listCountries(),
        ]);
    }

    public function show(string $slug, CountryViewModel $countries, HotelViewModel $hotels): View
    {
        $country = $countries->oneCountry($slug);

        abort_if(!$country, 404);

        return view('pages.countries.show', [
            'country' => $country,
            'hotels' => $hotels->hotelsOfCountry($country->id),
        ]);
    }
}
