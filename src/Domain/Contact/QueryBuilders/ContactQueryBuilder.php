<?php

namespace Domain\Contact\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class ContactQueryBuilder extends Builder
{
    public function ofSite(int $siteId): static
    {
        return $this->where('site_id', $siteId);
    }
}
