<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

///////////////////SPA routes//////////////////////////
Route::get(
    '/{any?}',
    [HomeController::class, 'index']
)
    ->where('any', '^(?!api\/)[\/\w\.\,-]*');