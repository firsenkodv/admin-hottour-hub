<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Contact\Pages;

use App\Models\Site;
use App\MoonShine\Resources\Contact\ContactResource;
use App\MoonShine\Resources\Site\SiteResource;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<ContactResource>
 */
final class ContactIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make(
                'Сайт',
                'site',
                formatted: static fn (Site $model) => $model->title,
                resource: SiteResource::class,
            ),

            Text::make('Телефон', 'phone'),
            Email::make('Email', 'email'),
            Text::make('Адрес', 'address'),
        ];
    }
}
