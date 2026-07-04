<?php

namespace Domain\Site\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class SiteQueryBuilder extends Builder
{
    public function active(): static
    {
        return $this->where('is_active', true);
    }
}
