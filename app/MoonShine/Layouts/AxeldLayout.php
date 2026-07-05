<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;
use App\MoonShine\Resources\MoonShineUser\MoonShineUserResource;
use App\MoonShine\Resources\Site\SiteResource;
use App\MoonShine\Resources\Country\CountryResource;
use App\MoonShine\Resources\Hotel\HotelResource;
use App\MoonShine\Resources\Travelcategory\TravelcategoryResource;
use App\MoonShine\Resources\Travelitem\TravelitemResource;
use App\MoonShine\Resources\Tour\TourResource;
use App\MoonShine\Resources\Hottour\HottourResource;
use App\MoonShine\Resources\Info\InfoResource;
use App\MoonShine\Resources\Contact\ContactResource;
use App\MoonShine\Resources\Review\ReviewResource;
use App\MoonShine\Resources\Document\DocumentResource;
use MoonShine\AssetManager\Js;
use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\ColorManager\Palettes\PurplePalette;
use MoonShine\ColorManager\ColorManager;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Contracts\ColorManager\PaletteContract;
use MoonShine\MenuManager\MenuDivider;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;
use YuriZoom\MoonShineMediaManager\Pages\MediaManagerPage;


final class AxeldLayout extends AppLayout
{
    /**
     * @var null|class-string<PaletteContract>
     */
    protected ?string $palette = PurplePalette::class;

    protected function assets(): array
    {
        return [
            ...parent::assets(),
            new Js('/js/admin/tab-persist.js'),
        ];
    }

    protected function menu(): array
    {
        return [
            MenuGroup::make('Пользователи', [
                MenuItem::make(MoonShineUserResource::class, 'Админ', 'user'),
                MenuDivider::make(),
            ]),

            MenuGroup::make(static fn() => __('Каталог'), [
                MenuItem::make(CountryResource::class, 'Страны', 'flag'),
                MenuItem::make(HotelResource::class, 'Отели', 'building-office'),
                MenuItem::make(TravelcategoryResource::class, 'Полезное: категории', 'light-bulb'),
                MenuItem::make(TravelitemResource::class, 'Полезное: статьи', 'document-text'),
                MenuItem::make(TourResource::class, 'Туры', 'paper-airplane'),
                MenuItem::make(HottourResource::class, 'Горящие туры', 'fire'),
                MenuItem::make(InfoResource::class, 'О нас', 'information-circle'),
                MenuItem::make(ContactResource::class, 'Контакты', 'phone'),
                MenuItem::make(ReviewResource::class, 'Отзывы', 'star'),
                MenuItem::make(DocumentResource::class, 'Документы', 'document'),
            ]),

            MenuGroup::make(static fn() => __('Мультисайт'), [
                MenuItem::make(SiteResource::class, 'Сайты группы', 'globe-alt'),
            ]),

            MenuGroup::make(static fn() => __('Настройки'), [
                MenuItem::make(MediaManagerPage::class, 'Media', 'film'),
            ]),
        ];
    }

    /**
     * @param ColorManager $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);

        // $colorManager->primary('#00000');
    }

    protected function getFooterCopyright(): string
    {
        return \sprintf(
            <<<'HTML'
                &copy; %d Hot Tour Group
                HTML,
            now()->year,
        );
    }

    protected function getFooterMenu(): array
    {
        return [
            config('app.url') => 'WebSite',
        ];
    }
}
