<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Travelitem;

use App\Models\Travelitem;
use App\MoonShine\Resources\Travelitem\Pages\TravelitemFormPage;
use App\MoonShine\Resources\Travelitem\Pages\TravelitemIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\Support\Attributes\Icon;

/**
 * @extends ModelResource<Travelitem, TravelitemIndexPage, TravelitemFormPage, null>
 */
#[Icon('document-text')]
#[Group('Каталог', 'building-office-2')]
class TravelitemResource extends ModelResource
{
    protected string $model = Travelitem::class;

    protected string $column = 'title';

    protected string $sortColumn = 'sorting';

    protected array $with = ['site', 'travelcategory'];

    protected bool $simplePaginate = true;

    public function getTitle(): string
    {
        return 'Полезное: статьи';
    }

    protected function pages(): array
    {
        return [
            TravelitemIndexPage::class,
            TravelitemFormPage::class,
        ];
    }

    protected function search(): array
    {
        return [
            'id',
            'title',
            'slug',
        ];
    }
}
