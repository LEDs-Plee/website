<?php

use App\Http\Controllers\StatsController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ToiletController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ToiletController::class, 'show'])->name('show');
Route::prefix('stats')->name('stats')->group(function () {
    Route::get('/', [StatsController::class, 'overview'])->name('overview');
});
Route::get('/status/{toilet}/{secret}/{status}', [ToiletController::class, 'store'])->name('store');
