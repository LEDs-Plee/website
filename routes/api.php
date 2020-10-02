<?php

use App\Http\Controllers\ToiletController;
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

Route::get('/status/{toilet}/{secret}/{status}', [ToiletController::class, 'store'])->name('store');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
