<?php

namespace Domain\Info\ViewModels;

use App\Models\Info;
use Support\Traits\Makeable;

class InfoViewModel
{
    use Makeable;

    public function aboutOfSite(int $siteId): ?Info
    {
        return Info::query()
            ->ofSite($siteId)
            ->first();
    }
}
