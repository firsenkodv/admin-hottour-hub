<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShine;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;
use App\MoonShine\Resources\MoonShineUser\MoonShineUserResource;
use App\MoonShine\Resources\MoonShineUserRole\MoonShineUserRoleResource;
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

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  CoreContract<MoonShineConfigurator>  $core
     */
    public function boot(CoreContract $core): void
    {
        $core
            ->resources([
                CountryResource::class,
                HotelResource::class,
                TravelcategoryResource::class,
                TravelitemResource::class,
                TourResource::class,
                HottourResource::class,
                InfoResource::class,
                ContactResource::class,
                ReviewResource::class,
                DocumentResource::class,
                SiteResource::class,
                MoonShineUserResource::class,
                MoonShineUserRoleResource::class,
            ])
            ->pages([
                ...$core->getConfig()->getPages(),
            ])
        ;
    }
}
