<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Tour;

use App\Models\Tour;
use App\MoonShine\Resources\Tour\Pages\TourFormPage;
use App\MoonShine\Resources\Tour\Pages\TourIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\Support\Attributes\Icon;

/**
 * @extends ModelResource<Tour, TourIndexPage, TourFormPage, null>
 */
#[Icon('paper-airplane')]
#[Group('Каталог', 'building-office-2')]
class TourResource extends ModelResource
{
    protected string $model = Tour::class;

    protected string $column = 'title';

    protected string $sortColumn = 'sorting';

    protected array $with = ['site', 'country'];

    protected bool $simplePaginate = true;

    public function getTitle(): string
    {
        return 'Туры';
    }

    protected function pages(): array
    {
        return [
            TourIndexPage::class,
            TourFormPage::class,
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
