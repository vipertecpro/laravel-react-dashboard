<?php

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\be\BlogCategoriesController;
use App\Http\Controllers\be\BlogsController;
use App\Http\Controllers\be\BlogTagsController;
use App\Http\Controllers\be\BookCategoriesController;
use App\Http\Controllers\be\BooksController;
use App\Http\Controllers\be\BookTagsController;
use App\Http\Controllers\be\CommentsController;
use App\Http\Controllers\be\CustomersController;
use App\Http\Controllers\global\GlobalSettingController;
use App\Http\Controllers\global\OrdersController;
use App\Http\Controllers\global\PageController;
use App\Http\Controllers\global\PaymentsController;
use App\Http\Controllers\global\PermissionController;
use App\Http\Controllers\global\ProfileController;
use App\Http\Controllers\global\RoleController;
use App\Http\Controllers\global\SectionController;
use App\Http\Controllers\global\TestimonialsController;
use App\Http\Controllers\global\UserController;
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
                Route::get('/list', [RoleController::class, 'list'])->name('list');
                Route::get('/create', [RoleController::class, 'create'])->name('create');
                Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('edit');
                Route::patch('/storeUpdate/{id?}', [RoleController::class, 'storeUpdate'])->name('storeUpdate');
                Route::get('/remove/{id}', [RoleController::class, 'remove'])->name('remove');
            });
            Route::group([
                'as' => 'sections.',
                'prefix' => 'sections'
            ], function () {
                Route::get('/list', [SectionController::class, 'list'])->name('list');
                Route::get('/create', [SectionController::class, 'create'])->name('create');
                Route::get('/edit/{id}', [SectionController::class, 'edit'])->name('edit');
                Route::patch('/storeUpdate/{id?}', [SectionController::class, 'storeUpdate'])->name('storeUpdate');
                Route::get('/remove/{id}', [SectionController::class, 'remove'])->name('remove');
            });
            Route::group([
                'as' => 'pages.',
                'prefix' => 'pages'
            ], function () {
                Route::get('/list', [PageController::class, 'list'])->name('list');
                Route::get('/create', [PageController::class, 'create'])->name('create');
                Route::get('/edit/{id}', [PageController::class, 'edit'])->name('edit');
                Route::patch('/storeUpdate/{id?}', [PageController::class, 'storeUpdate'])->name('storeUpdate');
                Route::get('/remove/{id}', [PageController::class, 'remove'])->name('remove');
            });
            Route::group([
                'as' => 'testimonials.',
                'prefix' => 'testimonials'
            ], function () {
                Route::get('/list', [TestimonialsController::class, 'list'])->name('list');
                Route::get('/create', [TestimonialsController::class, 'create'])->name('create');
                Route::get('/edit/{id}', [TestimonialsController::class, 'edit'])->name('edit');
                Route::patch('/storeUpdate/{id?}', [TestimonialsController::class, 'storeUpdate'])->name('storeUpdate');
                Route::get('/remove/{id}', [TestimonialsController::class, 'remove'])->name('remove');
            });
            Route::group([
                'as' => 'orders.',
                'prefix' => 'orders'
            ], function () {
                Route::get('/list', [OrdersController::class, 'list'])->name('list');
                Route::get('/create', [OrdersController::class, 'create'])->name('create');
                Route::get('/edit/{id}', [OrdersController::class, 'edit'])->name('edit');
                Route::patch('/storeUpdate/{id?}', [OrdersController::class, 'storeUpdate'])->name('storeUpdate');
                Route::get('/remove/{id}', [OrdersController::class, 'remove'])->name('remove');
            });
            Route::group([
                'as' => 'payments.',
                'prefix' => 'payments'
            ], function () {
                Route::get('/list', [PaymentsController::class, 'list'])->name('list');
                Route::get('/create', [PaymentsController::class, 'create'])->name('create');
                Route::get('/edit/{id}', [PaymentsController::class, 'edit'])->name('edit');
                Route::patch('/storeUpdate/{id?}', [PaymentsController::class, 'storeUpdate'])->name('storeUpdate');
                Route::get('/remove/{id}', [PaymentsController::class, 'remove'])->name('remove');
            });
        });

        Route::group([
            'as' => 'be.',
            'prefix' => '/be',
        ], function () {
            Route::group([
                'as' => 'customers.',
                'prefix' => 'customers'
            ], function () {
                Route::get('/list', [CustomersController::class, 'list'])->name('list');
                Route::get('/create', [CustomersController::class, 'create'])->name('create');
                Route::get('/edit/{id}', [CustomersController::class, 'edit'])->name('edit');
                Route::patch('/storeUpdate/{id?}', [CustomersController::class, 'storeUpdate'])->name('storeUpdate');
                Route::get('/remove/{id}', [CustomersController::class, 'remove'])->name('remove');
            });
            Route::group([
                'as' => 'bookCategories.',
                'prefix' => 'bookCategories'
            ], function () {
                Route::get('/list', [BookCategoriesController::class, 'list'])->name('list');
                Route::get('/create', [BookCategoriesController::class, 'create'])->name('create');
                Route::get('/edit/{id}', [BookCategoriesController::class, 'edit'])->name('edit');
                Route::post('/storeUpdate/{id?}', [BookCategoriesController::class, 'storeUpdate'])->name('storeUpdate');
                Route::get('/remove/{id}', [BookCategoriesController::class, 'remove'])->name('remove');
                Route::get('/removeAll', [BookCategoriesController::class, 'removeAll'])->name('removeAll');
            });
            Route::group([
                'as' => 'bookTags.',
                'prefix' => 'bookTags'
            ], function () {
                Route::get('/list', [BookTagsController::class, 'list'])->name('list');
                Route::get('/create', [BookTagsController::class, 'create'])->name('create');
                Route::get('/edit/{id}', [BookTagsController::class, 'edit'])->name('edit');
                Route::patch('/storeUpdate/{id?}', [BookTagsController::class, 'storeUpdate'])->name('storeUpdate');
                Route::get('/remove/{id}', [BookTagsController::class, 'remove'])->name('remove');
            });
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
                'as' => 'comments.',
                'prefix' => 'comments'
            ], function () {
                Route::get('/list', [CommentsController::class, 'list'])->name('list');
                Route::get('/create', [CommentsController::class, 'create'])->name('create');
                Route::get('/edit/{id}', [CommentsController::class, 'edit'])->name('edit');
                Route::patch('/storeUpdate/{id?}', [CommentsController::class, 'storeUpdate'])->name('storeUpdate');
                Route::get('/remove/{id}', [CommentsController::class, 'remove'])->name('remove');
            });
            Route::group([
                'as' => 'blogCategories.',
                'prefix' => 'blogCategories'
            ], function () {
                Route::get('/list', [BlogCategoriesController::class, 'list'])->name('list');
                Route::get('/create', [BlogCategoriesController::class, 'create'])->name('create');
                Route::get('/edit/{id}', [BlogCategoriesController::class, 'edit'])->name('edit');
                Route::post('/storeUpdate/{id?}', [BlogCategoriesController::class, 'storeUpdate'])->name('storeUpdate');
                Route::get('/remove/{id}', [BlogCategoriesController::class, 'remove'])->name('remove');
                Route::get('/removeAll', [BlogCategoriesController::class, 'removeAll'])->name('removeAll');
            });
            Route::group([
                'as' => 'blogTags.',
                'prefix' => 'blogTags'
            ], function () {
                Route::get('/list', [BlogTagsController::class, 'list'])->name('list');
                Route::get('/create', [BlogTagsController::class, 'create'])->name('create');
                Route::get('/edit/{id}', [BlogTagsController::class, 'edit'])->name('edit');
                Route::patch('/storeUpdate/{id?}', [BlogTagsController::class, 'storeUpdate'])->name('storeUpdate');
                Route::get('/remove/{id}', [BlogTagsController::class, 'remove'])->name('remove');
            });
            Route::group([
                'as' => 'blogs.',
                'prefix' => 'blogs'
            ], function () {
                Route::get('/list', [BlogsController::class, 'list'])->name('list');
                Route::get('/create', [BlogsController::class, 'create'])->name('create');
                Route::get('/edit/{id}', [BlogsController::class, 'edit'])->name('edit');
                Route::patch('/storeUpdate/{id?}', [BlogsController::class, 'storeUpdate'])->name('storeUpdate');
                Route::get('/remove/{id}', [BlogsController::class, 'remove'])->name('remove');
            });

        });
    });
});

require __DIR__ . '/auth.php';
