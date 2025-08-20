<?php

use App\Http\Controllers\ContactFormsController;
use App\Http\Controllers\TestimonialsController;
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
});
