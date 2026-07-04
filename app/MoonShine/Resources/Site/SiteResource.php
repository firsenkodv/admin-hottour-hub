<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Site;

use App\Models\Site;
use App\MoonShine\Resources\Site\Pages\SiteFormPage;
use App\MoonShine\Resources\Site\Pages\SiteIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\Support\Attributes\Icon;

/**
 * @extends ModelResource<Site, SiteIndexPage, SiteFormPage, null>
 */
#[Icon('globe-alt')]
#[Group('Мультисайт', 'globe-alt')]
class SiteResource extends ModelResource
{
    protected string $model = Site::class;

    protected string $column = 'title';

    protected bool $simplePaginate = true;

    public function getTitle(): string
    {
        return 'Сайты группы';
    }

    protected function pages(): array
    {
        return [
            SiteIndexPage::class,
            SiteFormPage::class,
        ];
    }

    protected function search(): array
    {
        return [
            'id',
            'code',
            'title',
            'domain',
        ];
    }
}
