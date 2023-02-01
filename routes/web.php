<?php

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// User related routes
Route::get('/', [UserController::class, "showCorrectHomepage"])->name('login');
Route::post('/register', [UserController::class, 'register'])->middleware('guest');
Route::post('/login', [UserController::class, 'login'])->middleware('guest');
Route::post('/logout', [UserController::class, 'logout'])->middleware('mustBeLoggedIn');
Route::get('/manage-avatar', [UserController::class, 'showAvatarForm'])->middleware('mustBeLoggedIn');
Route::post('/manage-avatar', [UserController::class, 'storeAvatar'])->middleware('mustBeLoggedIn');

// Blog post related routes
Route::get('/create-post', [PostController::class, 'showCreateForm'])->middleware('mustBeLoggedIn');
Route::post('/create-post', [PostController::class, 'storeNewPost'])->middleware('mustBeLoggedIn');
Route::get('/post/{post}', [PostController::class, 'viewSinglePost']);
Route::delete('/post/{post}', [PostController::class, 'deletePost'])->middleware('can:delete,post');
Route::put('/post/{post}', [PostController::class, 'editPost'])->middleware('can:update,post');

//follow related routes
Route::post('/create-follow/{user:username}', [FollowController::class, 'createFollow'])
->middleware('mustBeLoggedIn');;
Route::post('/remove-follow/{user:username}', [FollowController::class, 'removeFollow'])
->middleware('mustBeLoggedIn');;

//profile related routes
Route::get('/profile/{user:username}', [UserController::class, 'profile']);
Route::get('/post/{post}/edit', [PostController::class, 'showEditForm'])->middleware('can:update,post');

//admin page routes
Route::get('/admin-only', function () {
        return 'this is the admin page';
})->middleware('can:onlyAdminCanCome');
