<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Domain\Country\ViewModels\CountryViewModel;
use Domain\Site\ViewModels\SiteViewModel;
use Domain\Travelcategory\ViewModels\TravelcategoryViewModel;
use Domain\Travelitem\ViewModels\TravelitemViewModel;
use Illuminate\Contracts\View\View;

class TravelcategoryController extends Controller
{
    public function index(
        string $countrySlug,
        CountryViewModel $countries,
        TravelcategoryViewModel $categories,
        SiteViewModel $sites,
    ): View {
        $country = $countries->oneCountry($countrySlug);

        abort_if(!$country, 404);

        $site = $sites->current();

        abort_if(!$site, 500, 'Текущий сайт не настроен (config/multisite.php).');

        return view('pages.travelcategories.index', [
            'country' => $country,
            'categories' => $categories->categoriesOfCountry($site->id, $country->id),
        ]);
    }

    public function show(
        string $slug,
        TravelcategoryViewModel $categories,
        TravelitemViewModel $items,
        SiteViewModel $sites,
    ): View {
        $site = $sites->current();

        abort_if(!$site, 500, 'Текущий сайт не настроен (config/multisite.php).');

        $category = $categories->oneCategory($site->id, $slug);

        abort_if(!$category, 404);

        return view('pages.travelcategories.show', [
            'category' => $category,
            'items' => $items->itemsOfCategory($site->id, $category->id),
        ]);
    }
}
