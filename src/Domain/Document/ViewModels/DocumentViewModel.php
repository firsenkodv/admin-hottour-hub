<?php

namespace Domain\Document\ViewModels;

use App\Models\Document;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Support\Traits\Makeable;

class DocumentViewModel
{
    use Makeable;

    public function documentsOfSite(int $siteId, int $perPage = 20): LengthAwarePaginator
    {
        return Document::query()
            ->published()
            ->ofSite($siteId)
            ->ordered()
            ->paginate($perPage);
    }

    public function oneDocument(int $siteId, string $slug): ?Document
    {
        return Document::query()
            ->published()
            ->ofSite($siteId)
            ->bySlug($slug)
            ->first();
    }
}
