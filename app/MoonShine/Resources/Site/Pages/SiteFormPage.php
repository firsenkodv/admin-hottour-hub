<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Site\Pages;

use App\MoonShine\Resources\Site\SiteResource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Password;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Url;

/**
 * @extends FormPage<SiteResource, \App\Models\Site>
 */
final class SiteFormPage extends FormPage
{
    /**
     * @return list<\MoonShine\Contracts\UI\ComponentContract|\MoonShine\Contracts\UI\FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Box::make([
                ID::make(),

                Text::make('Код', 'code')
                    ->hint('ru, uz, kg, ...')
                    ->required(),

                Text::make('Название', 'title')
                    ->required(),

                Text::make('Домен', 'domain')
                    ->hint('hottour.ru')
                    ->required(),

                Url::make('Base API URL', 'api_base_url')
                    ->hint('https://hottour.ru/api/sync')
                    ->required(),

                Text::make('API Key', 'api_key')
                    ->required(),

                Password::make('API Secret', 'api_secret')
                    ->eye()
                    ->customAttributes(['autocomplete' => 'new-password']),

                Switcher::make('Активен', 'is_active')
                    ->default(true),
            ]),
        ];
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [
            'code' => 'required|string|max:16',
            'title' => 'required|string|max:255',
            'domain' => 'required|string|max:255',
            'api_base_url' => 'required|url|max:255',
            'api_key' => 'required|string|max:255',
            'api_secret' => $item->getKey() !== null ? 'sometimes|nullable|string' : 'required|string',
        ];
    }
}
