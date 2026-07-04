<?php

use App\Http\Controllers\Axios\AxiosController;
use App\Http\Controllers\FancyBox\FancyBoxController;
use Illuminate\Support\Facades\Route;

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
