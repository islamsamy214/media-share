<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Route;

//visits
Route::get('visit',[HomeController::class,'visit'])->name('new.visit');

//contact
Route::get('contacts', [ContactController::class, 'getContacts'])->name('get.contacts');
Route::post('message', [MessageController::class, 'sendMessage'])->name('send.message');

//about
Route::get('users', [UserController::class, 'getUsers'])->name('get.users');

//blogs
Route::get('blogs', [BlogController::class, 'getBlogs'])->name('get.blogs');
Route::get('blogs/{blog}', [BlogController::class, 'getBlog'])->name('get.blog');

//works
Route::get('works', [WorkController::class, 'getWorks'])->name('get.works');
Route::get('works/{work}', [WorkController::class, 'getWork'])->name('get.work');
