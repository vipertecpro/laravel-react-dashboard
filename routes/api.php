<?php

use App\Http\Controllers\Be\ApiController;
use App\Http\Controllers\Client\ClientApiController;
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
Route::get('endpoint',function(){
   return true;
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
    Route::post('/logout', [ClientApiController::class, 'logout'])->name('logout');
    Route::post('/login', [ClientApiController::class, 'login'])->name('login');
    Route::post('/getJwtToken', [ClientApiController::class, 'getJwtToken'])->name('getJwtToken');
    Route::post('/register', [ClientApiController::class, 'register'])->name('register');
    Route::middleware('jwt.verify')->group(function() {
        Route::get('/user', [ClientApiController::class, 'getUser'])->name('user');
        Route::get('/test', function() {
            return response()->json(['message' => 'Welcome to dashboard'], 200);
        })->name('testJwt');
    });

    Route::get('/books', [ClientApiController::class, 'books'])->name('books');
    Route::get('/book/{book_slug}', [ClientApiController::class, 'getSingleBookData'])->name('getSingleBookData');
    Route::get('/book/{book_slug}/bookReviews', [ClientApiController::class, 'singleBookReviews'])->name('singleBookReviews');


    Route::post('/createBook', [ClientApiController::class, 'createBook'])->name('createBook');
    Route::post('/createBookReview', [ClientApiController::class, 'createBookReview'])->name('createBookReview');
});
