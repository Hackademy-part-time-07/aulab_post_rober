<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RevisorController;

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
Route::get('/categories/{category}', [ArticleController::class, 'showArticlesCategory'])->name('categories.showArticlesCategory');
Route::get('/careers', [PublicController::class, 'careers'])->name('careers');
Route::post('/solicitud', [PublicController::class, 'store'])->name('career_request.store');
Route::get('/articles/author/{author}', [ArticleController::class, 'showByAuthor'])->name('articles.showByAuthor');
Route::get('/dashboardrev', [ArticleController::class, 'dashboardrev'])->name('dashboardrev');
Route::post('/admin/approvearticle/{id}', [AdminController::class, 'approveArticle'])->name('admin.approvearticle');
Route::post('/admin/deleteArticle/{id}', [AdminController::class, 'deleteArticle'])->name('admin.deleteArticle');

Route::post('/admin/toggleVisibility/{id}', [AdminController::class, 'toggleVisibility'])->name('admin.toggleVisibility');

Route::put('/admin/articles/{id}/update-category', [AdminController::class, 'updateCategory'])->name('admin.updateCategory');
Route::get('/searchArticles', [AdminController::class, 'searchArticles'])->name('admin.searchArticles');
Route::get('search', [ArticleController::class, 'search'])->name('search');

// Rutas accesibles para todos los usuarios

Route::middleware('auth')->group(function () {
    // Rutas accesibles solo para usuarios autenticados
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::put('/users/{userId}/updateRole', [AdminController::class, 'updateRole'])->name('admin.updateRole');
});

