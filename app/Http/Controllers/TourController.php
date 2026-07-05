<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Domain\Country\ViewModels\CountryViewModel;
use Domain\Site\ViewModels\SiteViewModel;
use Domain\Tour\ViewModels\TourViewModel;
use Illuminate\Contracts\View\View;

class TourController extends Controller
{
    public function index(
        string $countrySlug,
        CountryViewModel $countries,
        TourViewModel $tours,
        SiteViewModel $sites,
    ): View {
        $country = $countries->oneCountry($countrySlug);

        abort_if(!$country, 404);

        $site = $sites->current();

        abort_if(!$site, 500, 'Текущий сайт не настроен (config/multisite.php).');

        return view('pages.tours.index', [
            'country' => $country,
            'tours' => $tours->toursOfCountry($site->id, $country->id),
        ]);
    }

    public function show(string $slug, TourViewModel $tours, SiteViewModel $sites): View
    {
        $site = $sites->current();

        abort_if(!$site, 500, 'Текущий сайт не настроен (config/multisite.php).');

        $tour = $tours->oneTour($site->id, $slug);

        abort_if(!$tour, 404);

        return view('pages.tours.show', [
            'tour' => $tour,
        ]);
    }
}
