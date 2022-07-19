<?php

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

Route::prefix('v1')->group(function () {
	Route::post('/register', [\App\Http\Controllers\AuthenticationController::class, 'register']);
	Route::post('/login', [\App\Http\Controllers\AuthenticationController::class, 'login']);
	Route::get('activate/{activation_token}', [\App\Http\Controllers\AuthenticationController::class, 'activate']);
});
