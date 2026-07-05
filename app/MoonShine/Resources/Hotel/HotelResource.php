<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Hotel;

use App\Models\Hotel;
use App\MoonShine\Resources\Hotel\Pages\HotelFormPage;
use App\MoonShine\Resources\Hotel\Pages\HotelIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\Support\Attributes\Icon;

/**
 * @extends ModelResource<Hotel, HotelIndexPage, HotelFormPage, null>
 */
#[Icon('building-office')]
#[Group('Каталог', 'building-office-2')]
class HotelResource extends ModelResource
{
    protected string $model = Hotel::class;

    protected string $column = 'title';

    protected string $sortColumn = 'sorting';

    protected array $with = ['country'];

    protected bool $simplePaginate = true;

    public function getTitle(): string
    {
        return 'Отели';
    }

    protected function pages(): array
    {
        return [
            HotelIndexPage::class,
            HotelFormPage::class,
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
