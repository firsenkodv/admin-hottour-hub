<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Country;

use App\Models\Country;
use App\MoonShine\Resources\Country\Pages\CountryFormPage;
use App\MoonShine\Resources\Country\Pages\CountryIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\Support\Attributes\Icon;

/**
 * @extends ModelResource<Country, CountryIndexPage, CountryFormPage, null>
 */
#[Icon('flag')]
#[Group('Каталог', 'building-office-2')]
class CountryResource extends ModelResource
{
    protected string $model = Country::class;

    protected string $column = 'title';

    protected string $sortColumn = 'sorting';

    protected bool $simplePaginate = true;

    public function getTitle(): string
    {
        return 'Страны';
    }

    protected function pages(): array
    {
        return [
            CountryIndexPage::class,
            CountryFormPage::class,
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
