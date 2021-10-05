<?php

use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WorkCategoryController;
use App\Http\Controllers\Admin\WorkController;
use Illuminate\Support\Facades\Route;

//admin routes
Route::group(['middleware' => ['auth', 'verified']], function () {
    //dashboard page
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //users
    Route::resource('/users', UserController::class)->except(['show', 'create']);
    Route::post('/users/{user}/verify', [UserController::class, 'verify'])->name('users.verify');
    Route::put('/users/{user}/profile', [UserController::class, 'updateProfile'])->name('users.profile.update');

    //blog categories
    Route::resource('/blogcategories', BlogCategoryController::class)->except(['show', 'create']);
    Route::get('/getblogcategories', [BlogCategoryController::class, 'getBlogCategories']);

    //blogs
    Route::resource('/blogs', BlogController::class)->except('create');

    //work categories
    Route::resource('/workcategories', WorkCategoryController::class)->except(['show', 'create']);
    Route::get('/getworkcategories', [WorkCategoryController::class, 'getWorkCategories']);

    //works
    Route::resource('/works', WorkController::class)->except('create');

    //messages
    Route::resource('/messages', MessageController::class)->except(['create', 'edit', 'update']);

    //contacts
    Route::resource('/contacts', ContactController::class)->only(['index', 'edit', 'update']);
});
