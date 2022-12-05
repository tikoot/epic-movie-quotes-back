<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class,'register'])->name('register');
;
Route::get('email-verification', [AuthController::class, 'verify'])->name('verification.verify');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('jwt.auth')->name('logout');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('forgot.password');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset.password');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/me', [AuthController::class, 'me'])->middleware('jwt.auth')->name('me');

Route::get('/auth/google/redirect', [GoogleController::class, 'redirectToProvider'])->name('redirect.provider');
Route::get('/auth/google/callback', [GoogleController::class, 'handleProviderCallback'])->name('handle.callback');

Route::post('/movies/store', [MovieController::class, 'store'])->name('movies.store');
Route::get('/movies/show/{id}', [MovieController::class, 'show'])->name('movies.show');
Route::get('/movies/{id}', [MovieController::class, 'showMovie'])->name('movie.show');
Route::post('/movies/update', [MovieController::class, 'update'])->name('movie.update');
