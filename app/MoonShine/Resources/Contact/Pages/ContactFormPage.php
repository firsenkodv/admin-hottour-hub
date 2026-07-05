<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Contact\Pages;

use App\Models\Site;
use App\MoonShine\Resources\Contact\ContactResource;
use App\MoonShine\Resources\Site\SiteResource;
use Domain\Site\ViewModels\SiteViewModel;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends FormPage<ContactResource, \App\Models\Contact>
 */
final class ContactFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Box::make([
                ID::make(),

                BelongsTo::make(
                    'Сайт',
                    'site',
                    formatted: static fn (Site $model) => $model->title,
                    resource: SiteResource::class,
                )
                    ->required()
                    ->default(SiteViewModel::make()->current()?->id)
                    ->valuesQuery(static fn (Builder $q) => $q->select(['id', 'title'])),

                Text::make('Телефон', 'phone'),
                Email::make('Email', 'email'),
                Text::make('Адрес', 'address'),
                Text::make('Режим работы', 'working_hours'),
                Textarea::make('Код карты (embed)', 'map_embed'),
                Textarea::make('Дополнительный текст', 'text'),
            ]),
        ];
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [
            'site_id' => [
                'required',
                'exists:sites,id',
                Rule::unique('contacts', 'site_id')->ignore($item->getKey()),
            ],
            'email' => 'nullable|email',
        ];
    }
}
