<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\userController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('create-user', [userController::class, 'createUser']);
Route::get('get-users', [userController::class, 'getUsers']);
Route::get('get-user-detail/{id}', [userController::class, 'getUserDetail']);
Route::post('update-user-detail/{id}', [userController::class, 'updateUser']);