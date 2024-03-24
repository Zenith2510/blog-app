<?php

use App\Livewire\Post;
use App\Livewire\PostDetail;
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

Route::view('/', 'dashboard')
    ->middleware(['auth'])
    ->name('dashboard');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
Route::middleware('auth')->group(function () {
    Route::get('/posts', Post::class)->name('posts');

    Route::get('/posts/{id}', PostDetail::class)->name('post-detail');
});

require __DIR__ . '/auth.php';
