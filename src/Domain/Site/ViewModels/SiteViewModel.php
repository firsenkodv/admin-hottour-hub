<?php

namespace Domain\Site\ViewModels;

use App\Models\Site;
use Illuminate\Support\Collection;
use Support\Traits\Makeable;

class SiteViewModel
{
    use Makeable;

    public function activeSites(): Collection
    {
        return Site::query()->active()->get();
    }
}
