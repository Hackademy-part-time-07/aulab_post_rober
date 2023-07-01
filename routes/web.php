<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\User;


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

Route::get('/', [ArticleController::class, 'home'])->name('home');
Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/categories/{category}', [ArticleController::class, 'showArticles'])->name('categories.showArticles');
Route::get('/careers', [PublicController::class, 'careers'])->name('careers');
Route::post('/solicitud', [PublicController::class, 'store'])->name('career_request.store');
Route::get('/articles/author/{author}', [ArticleController::class, 'showByAuthor'])->name('articles.showByAuthor');
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
Route::put('/users/{userId}/updateRole', [AdminController::class, 'updateRole'])->name('admin.updateRole');



Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
Route::put('/users/{userId}/updateRole', [AdminController::class, 'updateRole'])->name('admin.updateRole');

});
