<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Hottour;

use App\Models\Hottour;
use App\MoonShine\Resources\Hottour\Pages\HottourFormPage;
use App\MoonShine\Resources\Hottour\Pages\HottourIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\Support\Attributes\Icon;

/**
 * @extends ModelResource<Hottour, HottourIndexPage, HottourFormPage, null>
 */
#[Icon('fire')]
#[Group('Каталог', 'building-office-2')]
class HottourResource extends ModelResource
{
    protected string $model = Hottour::class;

    protected string $column = 'title';

    protected string $sortColumn = 'sorting';

    protected array $with = ['site', 'country', 'hotel'];

    protected bool $simplePaginate = true;

    public function getTitle(): string
    {
        return 'Горящие туры';
    }

    protected function pages(): array
    {
        return [
            HottourIndexPage::class,
            HottourFormPage::class,
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
