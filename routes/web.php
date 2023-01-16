<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
	return view('welcome');
});

Route::controller(EmailVerificationController::class)->group(function () {
	Route::get('/test', 'show');
});

Route::get('/swagger', fn () => App::isProduction() ? response(status: 403) : view('swagger.swagger'))->name('swagger');
