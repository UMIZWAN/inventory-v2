<?php

use Illuminate\Support\Facades\Route;
use Modules\MIS\Http\Controllers\MISController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('mis', MISController::class)->names('mis');
});
