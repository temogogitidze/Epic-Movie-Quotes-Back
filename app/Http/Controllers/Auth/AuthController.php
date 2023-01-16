<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequests\LoginRequest;
use App\Http\Requests\AuthRequests\RegisterRequest;
use App\Http\Requests\EmailVerification\SendEmailVerificationRequest;
use App\Mail\VerifyEmail;
use App\Models\Email;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
	public function register(RegisterRequest $request): JsonResponse
	{
		$user = User::create([
			'username' => $request['username'],
			'email'    => $request['email'],
			'password' => Hash::make($request['password']),
			'token'    => Str::random(64),
		]);

		Mail::to($user->email)->send(new VerifyEmail($user));

		return response()->json('user created successfully', 200);
	}

	public function sendVerificationEmail(SendEmailVerificationRequest $request): JsonResponse
	{
		$user = User::where('email', $request['email'])->first();

		if (!$user)
		{
			return response()->json(['error' => 'User does not exist !'], 401);
		}

		Mail::to($user->email)->send(new VerifyEmail($user));

		return response()->json('email sent');
	}

	public function login(LoginRequest $request): JsonResponse
	{
		$login = request()->input('login');

		$fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

		request()->merge([$fieldType => $login]);

		$fields = [
			$fieldType => $login,
			'password' => $request['password'],
		];

		$authenticated = false;

		if ($fieldType === 'email')
		{
			$secondaryEmail = Email::where('email', $fields['email'])->first();
			$email = User::where('email', $fields['email'])->first();

			if ($email)
			{
				$authenticated = auth()->attempt(
					$fields
				);
			}

			if ($secondaryEmail)
			{
				$user = User::where('id', $secondaryEmail->user_id)->first();

				$request[$fieldType] = $user->email;

				$authenticated = auth()->attempt(
					['email' => $user->email, 'password' => $request['password']],
				);
			}
		}

		if ($fieldType === 'username')
		{
			$authenticated = auth()->attempt(
				$fields
			);
		}

		if (!$authenticated)
		{
			return response()->json(['message' => 'Wrong email or password'], 401);
		}

		$payload = [
			'exp' => Carbon::now()->addMinutes(30)->timestamp,
			'uid' => User::where($fieldType, '=', $request[$fieldType])->first()->id,
		];

		$jwt = JWT::encode($payload, config('auth.jwt_secret'), 'HS256');

		$cookie = cookie('access_token', $jwt, 30, '/', config('auth.front_end_top_level_domain'), true, true, false, 'Strict');

		return response()->json('success', 200)->withCookie($cookie);
	}

	public function logout(): JsonResponse
	{
		$cookie = cookie('access_token', '', 0, '/', config('auth.front_end_top_level_domain'), true, true, false, 'Strict');

		return response()->json('success', 200)->withCookie($cookie);
	}

	public function user(): JsonResponse
	{
		return response()->json(
			[
				'message' => 'authenticated successfully',
				'user'    => jwtUser(),
				'likes'   => Like::where('user_id', jwtUser()->id),
			],
			200
		);
	}
}
