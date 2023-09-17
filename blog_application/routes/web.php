<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FeedController;
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

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', [FeedController::class, 'index'])->name('dashboard');
Route::get('/feeds/create', [FeedController::class, 'create'])->name('feeds.create');
Route::post('/addFeeds', [FeedController::class, 'store'])->name('feeds.store');

// Edit Image
Route::get('/feeds/{image}/edit', [FeedController::class, 'edit'])->name('feeds.edit');
Route::put('/feeds/{image}', [FeedController::class, 'update'])->name('feeds.update');

// Delete Image
Route::delete('/feeds/{image}', [FeedController::class, 'destroy'])->name('feeds.destroy');




