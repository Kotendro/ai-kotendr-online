<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocsController;
use App\Http\Controllers\ApiKeyController;

// ApiKeyController
Route::get('/', [ApiKeyController::class, 'index'])->name('home');
Route::post('/check', [ApiKeyController::class, 'check'])->name('check');
Route::get('/info', [ApiKeyController::class, 'info'])->name('info');
Route::get('/logout', [ApiKeyController::class, 'logout'])->name('logout');

// DocsController
Route::prefix('docs')->name('docs.')->group(function () {
    Route::get('/', [DocsController::class, 'index'])->name('index');
    Route::get('/integration', [DocsController::class, 'integration'])->name('integration');
    Route::get('/models', [DocsController::class, 'models'])->name('models');
});
