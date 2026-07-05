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

    /**
     * Сайт, которому принадлежит контент этого инстанса (config('multisite.current_site_code')).
     */
    public function current(): ?Site
    {
        return Site::query()
            ->where('code', config('multisite.current_site_code'))
            ->first();
    }
}
