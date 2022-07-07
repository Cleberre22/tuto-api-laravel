<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ClubController;
use App\Http\Controllers\API\PlayerController;
use App\Http\Controllers\API\SportController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});

Route::apiResource("players", PlayerController::class);

Route::apiResource("clubs", ClubController::class);

Route::apiResource("sports", SportController::class);