<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Password::defaults(function () {
            return Password::min(5)
                /*      ->letters()
                      ->numbers()
                      ->symbols()
                      ->mixedCase()
                      ->uncompromised()*/;
        });

        // Конвенция shared/local (docs/hottour-group-multisite-architecture.html, Этап 1):
        // локальные сущности (туры, горящие туры, полезное, о нас, контакты) обязаны иметь site_id
        // ($table->siteId()); шейред-сущности (отели, отзывы, документы) site_id не имеют вовсе —
        // они одинаковы на каждом сайте и приходят синхронизацией из hub'а.
        Blueprint::macro('siteId', function (string $column = 'site_id') {
            /** @var Blueprint $this */
            return $this->foreignId($column)->constrained('sites')->cascadeOnDelete();
        });
    }
}
