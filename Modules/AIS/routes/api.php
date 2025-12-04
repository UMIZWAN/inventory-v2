<?php

use Illuminate\Support\Facades\Route;
use Modules\AIS\Http\Controllers\AISController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('ais', AISController::class)->names('ais');
});
