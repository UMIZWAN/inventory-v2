<?php

use Illuminate\Support\Facades\Route;
use Modules\MIS\Http\Controllers\MISController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('mis', MISController::class)->names('mis');
});
