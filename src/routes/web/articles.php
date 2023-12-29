<?php

use App\Http\Controllers\Web\ArticleController;
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

Route::get('/articles/create', [ArticleController::class, 'create'])
    ->name('articles.create');
Route::post('/articles', [ArticleController::class, 'store'])
    ->name('articles.store');
Route::put('/articles/{article}', [ArticleController::class, 'update'])
    ->name('articles.update');
Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])
    ->name('articles.delete');
Route::get('/articles/{article}', [ArticleController::class, 'show'])
    ->name('articles.show');
Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])
    ->name('articles.edit');
