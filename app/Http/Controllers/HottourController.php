<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Domain\Hottour\ViewModels\HottourViewModel;
use Domain\Site\ViewModels\SiteViewModel;
use Illuminate\Contracts\View\View;

class HottourController extends Controller
{
    public function index(HottourViewModel $hottours, SiteViewModel $sites): View
    {
        $site = $sites->current();

        abort_if(!$site, 500, 'Текущий сайт не настроен (config/multisite.php).');

        return view('pages.hottours.index', [
            'hottours' => $hottours->hottoursOfSite($site->id),
        ]);
    }

    public function show(string $slug, HottourViewModel $hottours, SiteViewModel $sites): View
    {
        $site = $sites->current();

        abort_if(!$site, 500, 'Текущий сайт не настроен (config/multisite.php).');

        $hottour = $hottours->oneHottour($site->id, $slug);

        abort_if(!$hottour, 404);

        return view('pages.hottours.show', [
            'hottour' => $hottour,
        ]);
    }
}
