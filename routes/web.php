<?php

use App\Http\Controllers\Axios\AxiosController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\FancyBox\FancyBoxController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\TravelcategoryController;
use App\Http\Controllers\TravelitemController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\HottourController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\Identity\IdentityController;
use App\Http\Controllers\Sync\SyncReceiveController;
use App\Http\Middleware\VerifyHubSignature;
use App\Http\Middleware\VerifySiteSignature;
use Illuminate\Support\Facades\Route;

/** Главная **/
Route::get('/', [HomeController::class, 'index'])->name('home');
/** ///Главная **/

/** Личный кабинет туриста (Этап 3 — Identity API, сторона сайта) **/
Route::controller(CustomerAuthController::class)->group(function () {
    Route::get('/register', 'showRegister')->name('register.show');
    Route::post('/register', 'register')->name('register');
    Route::get('/login', 'showLogin')->name('login.show');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
    Route::get('/forgot-password', 'showForgotPassword')->name('password.forgot.show');
    Route::post('/forgot-password', 'sendResetLink')->name('password.forgot');
    Route::get('/reset-password/{token}', 'showResetForm')->name('password.reset.show');
    Route::post('/reset-password', 'resetPassword')->name('password.reset');
});
/** ///Личный кабинет туриста **/

/** Identity API (Этап 3 — hub-only, включается IS_HUB=true в .env) **/
if (config('multisite.is_hub')) {
    Route::middleware(VerifySiteSignature::class)->prefix('identity')->controller(IdentityController::class)->group(function () {
        Route::post('/register', 'register')->name('identity.register');
        Route::post('/login', 'login')->name('identity.login');
        Route::post('/password/forgot', 'forgotPassword')->name('identity.password.forgot');
        Route::post('/password/reset', 'resetPassword')->name('identity.password.reset');
    });
}
/** ///Identity API **/

/** Content-sync (Этап 4 — приём push'ей от hub'а, всегда активно, не под is_hub) **/
Route::middleware(VerifyHubSignature::class)->prefix('api/sync')->controller(SyncReceiveController::class)->group(function () {
    Route::post('/countries', 'country')->name('sync.countries');
    Route::post('/hotels', 'hotel')->name('sync.hotels');
    Route::post('/reviews', 'review')->name('sync.reviews');
});
/** ///Content-sync **/

/** Каталог: Страны / Отели **/
Route::get('/countries', [CountryController::class, 'index'])->name('countries.index');
Route::get('/countries/{slug}', [CountryController::class, 'show'])->name('countries.show');
Route::get('/hotels/{slug}', [HotelController::class, 'show'])->name('hotels.show');
/** ///Каталог **/

/** Полезное (Travelcategory/Travelitem, локальная сущность — своя на каждом сайте) **/
Route::get('/countries/{slug}/useful', [TravelcategoryController::class, 'index'])->name('travelcategories.index');
Route::get('/useful/{slug}', [TravelcategoryController::class, 'show'])->name('travelcategories.show');
Route::get('/useful/{categorySlug}/{slug}', [TravelitemController::class, 'show'])->name('travelitems.show');
/** ///Полезное **/

/** Туры (локальная сущность — своя на каждом сайте) **/
Route::get('/countries/{slug}/tours', [TourController::class, 'index'])->name('tours.index');
Route::get('/tours/{slug}', [TourController::class, 'show'])->name('tours.show');
/** ///Туры **/

/** Горящие туры (локальная сущность — своя на каждом сайте, общая витрина без привязки к стране в URL) **/
Route::get('/hot-tours', [HottourController::class, 'index'])->name('hottours.index');
Route::get('/hot-tours/{slug}', [HottourController::class, 'show'])->name('hottours.show');
/** ///Горящие туры **/

/** О нас (локальная сущность — одна запись на сайт) **/
Route::get('/about', [AboutController::class, 'show'])->name('about.show');
/** ///О нас **/

/** Контакты (локальная сущность — одна запись на сайт) **/
Route::get('/contacts', [ContactController::class, 'show'])->name('contacts.show');
/** ///Контакты **/

/** Отзывы (шейред-сущность — одинаковые на каждом сайте) **/
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
/** ///Отзывы **/

/** Документы (локальная сущность — своя на каждом сайте) **/
Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
/** ///Документы **/

/** FancyBox AJAX **/
Route::controller(FancyBoxController::class)->group(function () {
    Route::post('/fancybox-ajax', 'fancybox');
});
/** ///FancyBox AJAX **/

/** Axios async forms **/
Route::controller(AxiosController::class)->group(function () {
    Route::post('/upload-form-async', 'async');
    Route::post('/call-me-blue', 'callMeBlue');
});
/** ///Axios async forms **/
