<?php

use Illuminate\Support\Facades\Route;
use Sfolador\Devices\Controllers\DeviceController;

Route::prefix('devices')->group(function () {
    Route::post('/attach', [DeviceController::class, 'attach'])->name('devices:attach');
});
