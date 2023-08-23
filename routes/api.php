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
    Route::get('/books', [ApiController::class, 'books'])->name('books');
    Route::get('/bookReviews', [ApiController::class, 'bookReviews'])->name('bookReviews');
});

Route::group([
    'as' => 'client.',
    'prefix' => 'client'
], function () {
    Route::post('/register', [ClientApiController::class, 'register'])->name('register');
    Route::post('/login', [ClientApiController::class, 'login'])->name('login');
    Route::get('/user', [ClientApiController::class, 'getUser'])->name('user');
    Route::middleware('jwt.verify')->group(function() {
        Route::get('/test', function() {
            return response()->json(['message' => 'Welcome to dashboard'], 200);
        })->name('testJwt');
        Route::get('/bookCategories', [ClientApiController::class, 'bookCategories'])->name('bookCategories');
    });
});
