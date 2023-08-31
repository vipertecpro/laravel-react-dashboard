<?php

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Be\BookReviewsController;
use App\Http\Controllers\Be\BooksController;
use App\Http\Controllers\Global\GlobalSettingController;
use App\Http\Controllers\Global\PermissionController;
use App\Http\Controllers\Global\ProfileController;
use App\Http\Controllers\Global\RoleController;
use App\Http\Controllers\Global\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    if (auth()->check() === true) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::group([
    'prefix' => '/dashboard',
    'middleware' => ['auth', 'verified']
], function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::group([
        'as' => 'dashboard.',
    ], function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
        Route::get('/globalSettings', [GlobalSettingController::class, 'edit'])->name('globalSettings.edit');
        Route::patch('/globalSettings', [GlobalSettingController::class, 'update'])->name('globalSettings.update');
        Route::group([
            'as' => 'global.',
            'prefix' => '/global',
        ], function () {
            Route::group([
                'as' => 'users.',
                'prefix' => 'users'
            ], function () {
                Route::get('/list', [UserController::class, 'list'])->name('list');
                Route::get('/create', [UserController::class, 'create'])->name('create');
                Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
                Route::patch('/storeUpdate/{id?}', [UserController::class, 'storeUpdate'])->name('storeUpdate');
                Route::get('/remove/{id}', [UserController::class, 'remove'])->name('remove');
            });
            Route::group([
                'as' => 'permissions.',
                'prefix' => 'permissions'
            ], function () {
                Route::get('/list', [PermissionController::class, 'list'])->name('list');
                Route::get('/create', [PermissionController::class, 'create'])->name('create');
                Route::get('/edit/{id}', [PermissionController::class, 'edit'])->name('edit');
                Route::patch('/storeUpdate/{id?}', [PermissionController::class, 'storeUpdate'])->name('storeUpdate');
                Route::get('/remove/{id}', [PermissionController::class, 'remove'])->name('remove');
            });
            Route::group([
                'as' => 'roles.',
                'prefix' => 'roles'
            ], function () {
                Route::get('/remove/{id}', [RoleController::class, 'remove'])->name('remove');
                Route::get('/list', [RoleController::class, 'list'])->name('list');
                Route::get('/create', [RoleController::class, 'create'])->name('create');
                Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('edit');
                Route::patch('/storeUpdate/{id?}', [RoleController::class, 'storeUpdate'])->name('storeUpdate');
                Route::get('/remove/{id}', [RoleController::class, 'remove'])->name('remove');
            });
        });

        Route::group([
            'as' => 'be.',
            'prefix' => '/be',
        ], function () {
            Route::group([
                'as' => 'books.',
                'prefix' => 'books'
            ], function () {
                Route::get('/list', [BooksController::class, 'list'])->name('list');
                Route::get('/create', [BooksController::class, 'create'])->name('create');
                Route::get('/edit/{id}', [BooksController::class, 'edit'])->name('edit');
                Route::patch('/storeUpdate/{id?}', [BooksController::class, 'storeUpdate'])->name('storeUpdate');
                Route::get('/remove/{id}', [BooksController::class, 'remove'])->name('remove');
            });
            Route::group([
                'as' => 'bookReviews.',
                'prefix' => 'bookReviews'
            ], function () {
                Route::get('/list', [BookReviewsController::class, 'list'])->name('list');
                Route::get('/create', [BookReviewsController::class, 'create'])->name('create');
                Route::get('/edit/{id}', [BookReviewsController::class, 'edit'])->name('edit');
                Route::patch('/storeUpdate/{id?}', [BookReviewsController::class, 'storeUpdate'])->name('storeUpdate');
                Route::get('/remove/{id}', [BookReviewsController::class, 'remove'])->name('remove');
            });
        });
    });
});

require __DIR__ . '/auth.php';
