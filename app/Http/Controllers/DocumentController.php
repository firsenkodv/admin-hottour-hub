<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Domain\Document\ViewModels\DocumentViewModel;
use Domain\Site\ViewModels\SiteViewModel;
use Illuminate\Contracts\View\View;

class DocumentController extends Controller
{
    public function index(DocumentViewModel $documents, SiteViewModel $sites): View
    {
        $site = $sites->current();

        abort_if(!$site, 500, 'Текущий сайт не настроен (config/multisite.php).');

        return view('pages.documents.index', [
            'documents' => $documents->documentsOfSite($site->id),
        ]);
    }
}
