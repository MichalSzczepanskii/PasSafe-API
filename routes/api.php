<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\FolderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
});

Route::middleware(['api', 'auth'])
    ->prefix('folders')
    ->name('folders.')
    ->group(function() {
    Route::get('', [FolderController::class, 'index'])->name('index');
});

Route::middleware(['api', 'auth'])
    ->prefix('entries')
    ->name('entries.')
    ->group(function() {
        Route::get('', [EntryController::class, 'index'])->name('index');
        Route::post('store', [EntryController::class, 'store'])->name('store');
        Route::delete('{entry}', [EntryController::class, 'remove'])
            ->where('entry', '[0-9]+')
            ->can('delete', 'entry')
            ->name('remove');
        Route::put('{entry}', [EntryController::class, 'edit'])
            ->where('entry', '[0-9]+')
            ->can('edit', 'entry')
            ->name('edit');
    });