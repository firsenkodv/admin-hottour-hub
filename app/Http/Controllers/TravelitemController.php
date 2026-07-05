<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Domain\Site\ViewModels\SiteViewModel;
use Domain\Travelitem\ViewModels\TravelitemViewModel;
use Illuminate\Contracts\View\View;

class TravelitemController extends Controller
{
    public function show(string $categorySlug, string $slug, TravelitemViewModel $items, SiteViewModel $sites): View
    {
        $site = $sites->current();

        abort_if(!$site, 500, 'Текущий сайт не настроен (config/multisite.php).');

        $item = $items->oneItem($site->id, $slug);

        abort_if(!$item, 404);

        return view('pages.travelitems.show', [
            'item' => $item,
        ]);
    }
}
