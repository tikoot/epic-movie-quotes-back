<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\QuoteController;
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

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register')->name('register');
    Route::post('/user/update', 'update')->name('user.update');
    Route::post('/login', 'login')->name('login');
    Route::get('/logout', 'logout')->middleware('jwt.auth')->name('logout');
    Route::get('email-verification', 'verify')->name('verification.verify');
    Route::get('/me', 'me')->middleware('jwt.auth')->name('me');
});

Route::controller(ForgotPasswordController::class)->group(function () {
    Route::post('/forgot-password', 'sendResetLink')->name('forgot.password');
    Route::post('/reset-password', 'resetPassword')->name('reset.password');
});

Route::controller(GoogleController::class)->group(function () {
    Route::get('/auth/google/redirect', 'redirectToProvider')->name('redirect.provider');
    Route::get('/auth/google/callback', 'handleProviderCallback')->name('handle.callback');
});

Route::controller(MovieController::class)->group(function () {
    Route::post('/movies/store', 'store')->name('movies.store');
    Route::get('/movies/show/{id}', 'show')->name('movies.show');
    Route::get('/movies/{id}', 'showMovie')->name('movie.show');
    Route::post('/movies/update', 'update')->name('movie.update');
    Route::delete('movies/{id}', 'destroy')->name('movies.destroy');
});

Route::controller(QuoteController::class)->group(function () {
    Route::post('/quotes/store', 'store')->name('quotes.store');
    Route::get('/quotes-all', 'allQuotes')->name('quotes.all');
    Route::get('/quotes/show/{id}', 'show')->name('quotes.show');
    Route::get('/quotes/{id}', 'showQuote')->name('quote.show');
    Route::delete('quotes/{id}', 'destroy')->name('quotes.destroy');
    Route::post('/quote/update', 'update')->name('quote.update');
});

Route::controller(CommentController::class)->group(function () {
    Route::post('/quotes/{id}/comments', 'store')->name('comments.store');
});

Route::controller(LikeController::class)->group(function () {
    Route::post('/quote-like', 'storeLike')->name('likes.store');
});

Route::controller(EmailController::class)->group(function () {
    Route::post('/add-email', 'store')->name('email.store');
    Route::get('/secondary-email/{token}', 'emailVerify')->name('email.secondary');
    Route::get('/user-email/{id}', 'getUserEmail')->name('user.email');
    Route::delete('delete-email/{id}', 'destroy')->name('email.destroy');
    Route::post('/make-primary', 'makePrimary')->name('email.primary');
});
