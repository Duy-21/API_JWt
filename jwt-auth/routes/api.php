<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
Route::group([
    'middleware' => 'assign.guard:api',
    'prefix' => 'v1',
    'as' => 'api.'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});
Route::group([
    'middleware' => ['assign.guard:api', 'jwt.verify', 'auth.jwt'],
    'prefix' => 'v1'

], function ($router) {
    Route::get('userInfo', [AuthController::class, 'getUserInfo']);
    Route::get('getData', [AuthController::class, 'getTokenFromOtherAttributes']);
    Route::get('getDataFromToken', [AuthController::class, 'getDataFromToken']);
});