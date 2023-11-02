<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

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


Route::get('/', [PostController::class, 'recentPost'])->name('home');
Route::get('/posts', [PostController::class, 'recentPost'])->name('recent_post');
Route::get('/posts/search', [PostController::class, 'tagSearch'])->name('tag_search');

Route::controller(PostController::class)->middleware(['auth'])->group(function(){
// Route::controller(PostController::class)->middleware(['verified'])->group(function(){
    Route::get('/posts/create', 'create')->name('posts.create');
    Route::post('/posts', 'store');
    Route::get('/posts/{post}/edit', 'editPost')->name('edit_post');
    Route::put('/posts/{post}', 'updatePost')->name('update_post');
    Route::post('/posts/{post}/participate', 'participate')->name('participate');
    Route::post('/posts/{post}/unparticipate', 'unparticipate')->name('unparticipate');
    Route::delete('/posts/{post}', 'deletePost')->name('delete_post');
});



// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/help', function () {
    return view('help.help');
})->name('help');


Route::middleware('auth')->group(function () {
// Route::middleware('verified')->group(function () {
    // Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
