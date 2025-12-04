<?php

use Illuminate\Support\Facades\Route;
use Modules\AIS\Http\Controllers\AISController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('ais', AISController::class)->names('ais');
});
