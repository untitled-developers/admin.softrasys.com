<?php

use App\Http\Controllers\ContactFormsController;
use App\Http\Controllers\DemoRequestsController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\LanguagesController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\ResellersController;
use App\Http\Controllers\TestimonialsController;
use App\Http\Controllers\CareersController;
use Illuminate\Support\Facades\Route;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\RoutesController;

Route::middleware(['web', 'auth:sanctum'])->group(function () {
    Route::prefix('testimonials')->group(function () {
        RoutesController::createResourcesRoutes(TestimonialsController::class);
        Route::put('/{id}/toggleHidden', [TestimonialsController::class,'toggleHidden']);
        Route::get('/{testimonial}', [TestimonialsController::class, 'getRecord']);
    });
    Route::prefix('contactForms')->group(function (){
        RoutesController::createResourcesRoutes(ContactFormsController::class);
    });
    Route::prefix('faqs')->group(function (){
        RoutesController::createResourcesRoutes(FaqsController::class);
        Route::put('/{id}/toggleHidden', [FaqsController::class, 'toggleHidden']);
    });
    Route::prefix('careers')->group(function (){
        RoutesController::createResourcesRoutes(CareersController::class);
        Route::put('/{id}/toggleHidden', [CareersController::class,'toggleHidden']);
        Route::get('/{career}', [CareersController::class, 'getRecord']);
    });
    Route::prefix('locations')->group(function (){
        RoutesController::createResourcesRoutes(LocationsController::class);
        Route::put('/{id}/toggleHidden', [LocationsController::class,'toggleHidden']);
    });
    Route::prefix('resellerForms')->group(function (){
        RoutesController::createResourcesRoutes(ResellersController::class);
    });
    Route::prefix('demoRequests')->group(function (){
        RoutesController::createResourcesRoutes(DemoRequestsController::class);
    });
    Route::prefix('languages')->name('languages')->group(function () {
        RoutesController::createResourcesRoutes(LanguagesController::class);
    });
});
