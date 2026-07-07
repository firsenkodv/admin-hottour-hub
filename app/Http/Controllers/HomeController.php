<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Domain\Country\ViewModels\CountryViewModel;
use Domain\Hottour\ViewModels\HottourViewModel;
use Domain\Review\ViewModels\ReviewViewModel;
use Domain\Site\ViewModels\SiteViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class HomeController extends Controller
{
    public function index(
        CountryViewModel $countries,
        HottourViewModel $hottours,
        ReviewViewModel $reviews,
        SiteViewModel $sites,
    ): View|RedirectResponse {
        // Хаб — админ-инструмент без публичной витрины (не привязан к стране),
        // поэтому у него нет "текущего сайта" в sites и своей главной страницы.
        if (config('multisite.is_hub')) {
            return redirect('/admin');
        }

        $site = $sites->current();

        abort_if(!$site, 500, 'Текущий сайт не настроен (config/multisite.php).');

        return view('pages.home.index', [
            'countries' => $countries->listCountries(perPage: 6),
            'hottours' => $hottours->hottoursOfSite($site->id, perPage: 6),
            'reviews' => $reviews->listReviews(perPage: 3),
        ]);
    }
}
