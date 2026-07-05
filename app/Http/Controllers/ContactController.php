<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Domain\Contact\ViewModels\ContactViewModel;
use Domain\Site\ViewModels\SiteViewModel;
use Illuminate\Contracts\View\View;

class ContactController extends Controller
{
    public function show(ContactViewModel $contacts, SiteViewModel $sites): View
    {
        $site = $sites->current();

        abort_if(!$site, 500, 'Текущий сайт не настроен (config/multisite.php).');

        $contact = $contacts->contactsOfSite($site->id);

        abort_if(!$contact, 404);

        return view('pages.contact.show', [
            'contact' => $contact,
        ]);
    }
}
