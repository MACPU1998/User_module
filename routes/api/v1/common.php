<?php

use App\Http\Controllers\Api\V1\Common\LocationController;
use App\Http\Controllers\Api\V1\Common\SettingController;
use App\Http\Controllers\FireBaseController;
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

//# ------------------------------------------------------------ #//
//# ---------------- Not Require Authentication ---------------- #//
//# ------------------------------------------------------------ #//
Route::prefix('common')->as('.common')->group(function () {
    Route::get('provinces', [LocationController::class, 'provinces'])->name('.provinces');
    Route::get('cities', [LocationController::class, 'cities'])->name('.cities');
    Route::get('rules', [SettingController::class, 'rules'])->name('.rules');

});

Route::post('update-device-token', [FireBaseController::class, 'updateDeviceToken']);
Route::get('send/notification', [FireBaseController::class, 'sendFcmNotification']);



