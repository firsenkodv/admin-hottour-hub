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
use Illuminate\Support\Facades\Route;

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
