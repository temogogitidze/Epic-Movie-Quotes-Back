<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\GoogleSocialiteController;
use App\Http\Controllers\Comments\CommentController;
use App\Http\Controllers\Likes\LikeController;
use App\Http\Controllers\Movies\MovieController;
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\Quotes\QuoteController;
use App\Http\Controllers\SecondaryEmails\SecondaryEmailsController;
use App\Http\Controllers\User\UserController;
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

Route::group(['middleware' => 'jwt.auth'], function () {
	Route::controller(AuthController::class)->group(function () {
		Route::get('user', 'user')->name('get.user');
		Route::post('logout', 'logout')->name('logout');
	});

	Route::controller(QuoteController::class)->group(function () {
		Route::post('quotes', 'store')->name('quotes.store');
		Route::get('quotes', 'index')->name('quotes.index');
		Route::get('quotes/{quote}', 'get')->name('quotes.get');
		Route::post('quotes/refresh', 'refresh')->name('quotes.refresh');
		Route::post('quotes/{quote}', 'update')->name('quotes.update');
		Route::delete('quotes/{quote}', 'destroy')->name('quotes.destroy');
	});

	Route::controller(MovieController::class)->group(function () {
		Route::post('movies', 'store')->name('movies.store');
		Route::get('movies', 'index')->name('movies.index');
		Route::get('movies/{movie}', 'get')->name('movies.get');
		Route::post('movies/{movie}', 'update')->name('movies.update');
		Route::delete('movies/{movie}', 'destroy')->name('movies.destroy');
	});

	Route::controller(CommentController::class)->group(function () {
		Route::post('comments', 'store')->name('comments.store');
	});

	Route::controller(LikeController::class)->group(function () {
		Route::post('like', 'like')->name('like');
		Route::post('likes/{quote:id}/likeable', 'likeable')->name('likeable');
	});

	Route::controller(UserController::class)->group(function () {
		Route::post('user/update', 'update')->name('user.update');
	});

	Route::controller(SecondaryEmailsController::class)->group(function () {
		Route::post('secondary-email', 'store')->name('secondary_email.store');
		Route::post('add-secondary-email', 'addSecondaryEmail')->name('secondary_email.add');
		Route::get('secondary-emails', 'get')->name('secondary_emails.get');
		Route::delete('secondary-emails/{id}', 'destroy')->name('secondary_emails.destroy');
	});

	Route::controller(NotificationController::class)->group(function () {
		Route::get('get-notifications', 'index')->name('notifications.index');
		Route::get('get-unread-notifications', 'unread')->name('notifications.unread');
		Route::post('mark-read', 'mark')->name('notification.mark');
	});
});

Route::group(['middleware' => 'guest:api'], function () {
	Route::controller(ForgotPasswordController::class)->group(function () {
		Route::post('forgot-password', 'submitForgetPasswordForm')->name('forgot_password.submit');
		Route::post('user-email', 'getUserEmail')->name('user_email.get');
		Route::post('reset-password/{token}', 'submitResetPasswordForm')->name('reset_password.submit');
	});

	Route::controller(AuthController::class)->group(function () {
		Route::post('register', 'register')->name('register');
		Route::post('verify-email', 'sendVerificationEmail')->name('verify_email.send');
		Route::post('login', 'login')->name('login');
	});

	Route::controller(EmailVerificationController::class)->group(function () {
		Route::post('email/{token}', 'verifyUser')->name('email.verify');
		Route::post('secondary-email/{token}', 'verifyUser')->name('secondary_email.verify');
	});

	Route::controller(GoogleSocialiteController::class)->group(function () {
		Route::get('auth/google', 'redirectToGoogle')->name('google.redirect');
		Route::get('google', 'handleCallback')->name('google.handle_callback');
	});
});
