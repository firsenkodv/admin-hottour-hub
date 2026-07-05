<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Info;

use App\Models\Info;
use App\MoonShine\Resources\Info\Pages\InfoFormPage;
use App\MoonShine\Resources\Info\Pages\InfoIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\Support\Attributes\Icon;

/**
 * @extends ModelResource<Info, InfoIndexPage, InfoFormPage, null>
 */
#[Icon('information-circle')]
#[Group('Каталог', 'building-office-2')]
class InfoResource extends ModelResource
{
    protected string $model = Info::class;

    protected string $column = 'title';

    protected array $with = ['site'];

    protected bool $simplePaginate = true;

    public function getTitle(): string
    {
        return 'О нас';
    }

    protected function pages(): array
    {
        return [
            InfoIndexPage::class,
            InfoFormPage::class,
        ];
    }

    protected function search(): array
    {
        return [
            'id',
            'title',
        ];
    }
}
