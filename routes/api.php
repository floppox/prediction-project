<?php

use App\Http\Controllers\Api\PredictionController;
use App\Http\Controllers\Api\TourController;
use App\Http\Controllers\Api\TournamentController;
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

Route::get('/tour/list', [TourController::class, 'index']);
Route::post('/tour/play', [TourController::class, 'playNextTour']);
Route::get('/tour/{tour_number}', [TourController::class, 'show']);

Route::get('/tournament/table', [TournamentController::class, 'showTable']);
Route::post('/tournament/toss', [TournamentController::class, 'coinToss']);

Route::get('/prediction', [PredictionController::class]);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
