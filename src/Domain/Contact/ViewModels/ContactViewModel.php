<?php

namespace Domain\Contact\ViewModels;

use App\Models\Contact;
use Support\Traits\Makeable;

class ContactViewModel
{
    use Makeable;

    public function contactsOfSite(int $siteId): ?Contact
    {
        return Contact::query()
            ->ofSite($siteId)
            ->first();
    }
}
