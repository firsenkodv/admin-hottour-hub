<?php

namespace Domain\Info\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class InfoQueryBuilder extends Builder
{
    public function ofSite(int $siteId): static
    {
        return $this->where('site_id', $siteId);
    }
}
