<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Country;

use App\Models\CountrySiteContent;
use App\MoonShine\Resources\Country\Pages\CountrySiteContentFormPage;
use App\MoonShine\Resources\Country\Pages\CountrySiteContentIndexPage;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * Не показывается в меню — используется только как вложенный RelationRepeater
 * в CountryFormPage (вкладка "По сайтам"). MoonShine требует зарегистрированный
 * resource для RelationRepeater/BelongsTo, даже когда своей отдельной страницы
 * в меню у сущности нет (см. память project_moonshine_gotchas).
 *
 * @extends ModelResource<CountrySiteContent, CountrySiteContentIndexPage, CountrySiteContentFormPage, null>
 */
class CountrySiteContentResource extends ModelResource
{
    protected string $model = CountrySiteContent::class;

    protected string $column = 'id';

    public function getTitle(): string
    {
        return 'Контент по сайтам';
    }

    protected function pages(): array
    {
        return [
            CountrySiteContentIndexPage::class,
            CountrySiteContentFormPage::class,
        ];
    }
}
