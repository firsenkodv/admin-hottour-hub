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
        $site = $sites->current();

        if (!$site) {
            // На хабе current_site_code обычно не совпадает ни с одним Site
            // (у хаба нет своей публичной витрины) — ведём в админку. Если же
            // это не хаб и сайт всё равно не найден — это реальная ошибка
            // конфигурации, а не хаб, поэтому остаётся 500.
            abort_if(!config('multisite.is_hub'), 500, 'Текущий сайт не настроен (config/multisite.php).');

            return redirect('/admin');
        }

        return view('pages.home.index', [
            'countries' => $countries->listCountries(perPage: 6),
            'hottours' => $hottours->hottoursOfSite($site->id, perPage: 6),
            'reviews' => $reviews->listReviews(perPage: 3),
        ]);
    }
}
