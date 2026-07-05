<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Domain\Info\ViewModels\InfoViewModel;
use Domain\Site\ViewModels\SiteViewModel;
use Illuminate\Contracts\View\View;

class AboutController extends Controller
{
    public function show(InfoViewModel $infos, SiteViewModel $sites): View
    {
        $site = $sites->current();

        abort_if(!$site, 500, 'Текущий сайт не настроен (config/multisite.php).');

        $about = $infos->aboutOfSite($site->id);

        abort_if(!$about, 404);

        return view('pages.about.show', [
            'about' => $about,
        ]);
    }
}
