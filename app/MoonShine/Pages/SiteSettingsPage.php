<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\Models\Site;
use Domain\Site\ViewModels\SiteViewModel;
use Illuminate\Http\Request;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\FormBuilderContract;
use MoonShine\Laravel\Pages\Page;
use MoonShine\Laravel\TypeCasts\ModelCaster;
use MoonShine\Support\Attributes\AsyncMethod;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Password;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Url;

/**
 * Настройки текущего сайта на спутнике — единственная запись из sites
 * (config('multisite.current_site_code')), без списка/создания/удаления,
 * т.к. на спутнике эта запись всегда одна. Полноценный CRUD (SiteResource)
 * остаётся только на хабе, где реально управляют реестром нескольких сайтов.
 * URL страницы (/admin/page/site-settings-page) генерируется MoonShine
 * автоматически из имени класса — не настраивается атрибутом Route.
 */
final class SiteSettingsPage extends Page
{
    public function getTitle(): string
    {
        return 'Настройки сайта';
    }

    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        return [
            '#' => $this->getTitle(),
        ];
    }

    /**
     * @return list<ComponentContract>
     */
    protected function components(): iterable
    {
        return [
            Box::make([$this->getForm()]),
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Text::make('Код', 'code')
                ->hint('ru, uz, kg, ...')
                ->disabled(),

            Text::make('Название', 'title')
                ->required(),

            Text::make('Домен', 'domain')
                ->required(),

            Url::make('Base API URL', 'api_base_url')
                ->required(),

            Text::make('API Key', 'api_key')
                ->required(),

            Password::make('API Secret', 'api_secret')
                ->eye()
                ->customAttributes(['autocomplete' => 'new-password']),

            Switcher::make('Активен', 'is_active'),
        ];
    }

    public function getForm(): FormBuilderContract
    {
        $site = SiteViewModel::make()->current();

        return FormBuilder::make(
            $this->getCore()->getRouter()->getEndpoints()->method(
                method: 'save',
                message: 'Сохранено',
                page: $this,
            ),
        )
            ->async()
            ->name('site-settings-form')
            ->fields($this->fields())
            ->fillCast($site, new ModelCaster(Site::class))
            ->submit('Сохранить');
    }

    #[AsyncMethod]
    public function save(Request $request): void
    {
        $site = SiteViewModel::make()->current();

        abort_if(!$site, 404);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'domain' => 'required|string|max:255',
            'api_base_url' => 'required|url|max:255',
            'api_key' => 'required|string|max:255',
            'api_secret' => 'sometimes|nullable|string',
        ]);

        if (blank($data['api_secret'] ?? null)) {
            unset($data['api_secret']);
        }

        $data['is_active'] = $request->boolean('is_active');

        $site->update($data);
    }
}
