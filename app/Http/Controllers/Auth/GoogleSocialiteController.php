<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleSocialiteController extends Controller
{
	public function redirectToGoogle()
	{
		$url = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
		return response()->json(['url' => $url]);
	}

	public function handleCallback()
	{
		try
		{
			$googleUser = Socialite::driver('google')->stateless()->user();

			$existingUser = User::where('email', $googleUser->email)->get()->first();

			if ($existingUser)
			{
				$existingUser['google_id'] = $googleUser->id;

				$payload = [
					'exp' => Carbon::now()->addMinutes(30)->timestamp,
					'uid' => User::where('email', '=', $existingUser->email)->first()->id,
				];

				$jwt = JWT::encode($payload, config('auth.jwt_secret'), 'HS256');

				$cookie = cookie('access_token', $jwt, 30, '/', config('auth.front_end_top_level_domain'), true, true, false, 'Strict');

				return Redirect::to(env('FRONTEND_URL') . '/newsfeed')->withCookie($cookie);
			}
			else
			{
				$newUser = User::create([
					'google_id'         => $googleUser->id,
					'email'             => $googleUser->email,
					'username'          => $googleUser->name,
					'password'          => Hash::make(str::random(10)),
					'token'             => Str::random(64),
					'email_verified_at' => Carbon::now()->toDateTimeString(),
				]);

				$payload = [
					'exp' => Carbon::now()->addMinutes(30)->timestamp,
					'uid' => User::where('email', '=', $newUser->email)->first()->id,
				];

				$jwt = JWT::encode($payload, config('auth.jwt_secret'), 'HS256');

				$cookie = cookie('access_token', $jwt, 30, '/', config('auth.front_end_top_level_domain'), true, true, false, 'Strict');

				return Redirect::to(env('FRONTEND_URL') . '/newsfeed')->withCookie($cookie);
			}
		}
		catch (Exception $e)
		{
			return redirect(env('FRONTEND_URL'));
		}
	}
}
