<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\PushController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\WasherController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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

Auth::routes();

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Full user routes
Route::middleware(['auth', 'verified', 'approved'])->group(function () {

    //Stats routes
    Route::controller(StatsController::class)->prefix('stats')->name('stats')->group(function () {
        Route::get('/', 'overview')->name('overview');
        Route::get('download', 'download')->name('download');
    });

    //User routes
    Route::controller(\App\Http\Controllers\UserController::class)->prefix('user')->name('user.')->group(function () {
        Route::get('notify_washer', 'notifyWasher')->name('notify_washer');
        Route::get('notify_toilet', 'notifyToilet')->name('notify_toilet');
    });

    //Push notification routes
    Route::prefix('push')->name('push')->group(function () {
        Route::post('subscribe', [PushController::class, 'subscribe'])->name('subscribe');
        Route::post('unsubscribe', [PushController::class, 'unsubscribe'])->name('unsubscribe');
    });

    //Admin routes
    Route::middleware('admin')->group(function () {
        //Toilet routes
        Route::controller(ToiletController::class)->prefix('toilets')->name('toilets.')->group(function () {
            Route::get('', 'list')->name('list');
            Route::post('create', 'create')->name('create');
            Route::get('edit/{toilet}', 'edit')->name('edit');
            Route::post('store/{toilet}', 'store')->name('store');
            Route::get('regenerate/{toilet}', 'regenerate')->name('regenerate');
            Route::get('delete/{toilet}', 'delete')->name('delete');
        });
        Route::controller(WasherController::class)->prefix('washers')->name('washers.')->group(function() {
            Route::get('', 'list')->name('list');
            Route::post('create', 'create')->name('create');
            Route::get('edit/{washer}', 'edit')->name('edit');
            Route::post('store/{washer}', 'store')->name('store');
            Route::get('delete/{washer}', 'delete')->name('delete');
            Route::get('update/{washer}', 'update')->name('update');
        });
    });
});

Route::get('/status/{toilet}/{secret}/{status}', [ToiletController::class, 'api'])->name('api');


Route::controller(ApprovalController::class)->prefix('approval')->name('approval.')->middleware('auth')->group(function () {
    Route::get('unapproved', 'unapproved')->name('unapproved');
    Route::middleware('admin')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('approve/{user}', 'approve')->name('approve');
    });
});


//Email verification routes
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');
