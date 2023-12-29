<?php

use App\Http\Controllers\Web\TrashController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/trash', [TrashController::class, 'index'])
    ->name('trash');
Route::post('/articles/{trashedArticle}/restore', [TrashController::class, 'restore'])
    ->name('trash.articles.restore');
