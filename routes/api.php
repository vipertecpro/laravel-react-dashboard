<?php

use App\Http\Controllers\be\ApiController;
use App\Http\Controllers\client\ClientApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group([
    'as' => 'fetch.',
    'prefix' => 'fetch'
], function () {
    Route::get('/users', [ApiController::class, 'users'])->name('users');
    Route::get('/permissions', [ApiController::class, 'permissions'])->name('permissions');
    Route::get('/roles', [ApiController::class, 'roles'])->name('roles');
    Route::get('/bookCategories', [ApiController::class, 'bookCategories'])->name('bookCategories');
    Route::get('/blogCategories', [ApiController::class, 'blogCategories'])->name('blogCategories');
});

Route::group([
    'as' => 'client.',
    'prefix' => 'client'
], function () {
    Route::get('/bookCategories', [ClientApiController::class, 'bookCategories'])->name('bookCategories');
});
