<?php

use App\Http\Controllers\ContactFormsController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\TestimonialsController;
use App\Http\Controllers\CareersController;
use Illuminate\Support\Facades\Route;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\RoutesController;

Route::middleware(['web', 'auth:sanctum'])->group(function () {
    Route::prefix('testimonials')->group(function () {
        RoutesController::createResourcesRoutes(TestimonialsController::class);
        Route::put('/{id}/toggleHidden', [TestimonialsController::class,'toggleHidden']);
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
    });
    Route::prefix('locations')->group(function (){
        RoutesController::createResourcesRoutes(LocationsController::class);
        Route::put('/{id}/toggleHidden', [LocationsController::class,'toggleHidden']);
    });
});
