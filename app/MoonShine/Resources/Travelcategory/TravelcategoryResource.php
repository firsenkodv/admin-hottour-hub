<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Travelcategory;

use App\Models\Travelcategory;
use App\MoonShine\Resources\Travelcategory\Pages\TravelcategoryFormPage;
use App\MoonShine\Resources\Travelcategory\Pages\TravelcategoryIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\Support\Attributes\Icon;

/**
 * @extends ModelResource<Travelcategory, TravelcategoryIndexPage, TravelcategoryFormPage, null>
 */
#[Icon('light-bulb')]
#[Group('Каталог', 'building-office-2')]
class TravelcategoryResource extends ModelResource
{
    protected string $model = Travelcategory::class;

    protected string $column = 'title';

    protected string $sortColumn = 'sorting';

    protected array $with = ['site', 'country'];

    protected bool $simplePaginate = true;

    public function getTitle(): string
    {
        return 'Полезное: категории';
    }

    protected function pages(): array
    {
        return [
            TravelcategoryIndexPage::class,
            TravelcategoryFormPage::class,
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
