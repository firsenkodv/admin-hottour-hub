<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Country\Pages;

use App\MoonShine\Resources\Country\CountryResource;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<CountryResource>
 */
final class CountryIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),
            Image::make('Изображение', 'image')->disk('public')->dir('countries'),
            Text::make('Название', 'title'),
            Text::make('Slug', 'slug'),
            Switcher::make('Опубликовано', 'published'),
        ];
    }
}
