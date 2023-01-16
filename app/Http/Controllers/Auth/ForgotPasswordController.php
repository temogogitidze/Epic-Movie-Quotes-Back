<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPassword\ResetPasswordRequest;
use App\Http\Requests\ForgotPassword\SubmitForgotPasswordRequest;
use App\Mail\ForgotPasswordEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
	public function submitForgetPasswordForm(SubmitForgotPasswordRequest $request): JsonResponse
	{
		$token = Str::random(64);

		DB::table('password_resets')->insert([
			'email'      => $request['email'],
			'token'      => $token,
			'created_at' => Carbon::now(),
		]);

		Mail::to($request['email'])->send(new ForgotPasswordEmail($token));

		return response()->json('Password reset email has been sent !', 200);
	}

	public function getUserEmail(Request $request): JsonResponse
	{
		$user = DB::table('password_resets')
			->where([
				'token' => $request->token,
			])
			->first();

		$userEmail = $user->email;
		return response()->json($userEmail, 200);
	}

	public function submitResetPasswordForm(ResetPasswordRequest $request): JsonResponse
	{
		$updatePassword = DB::table('password_resets')
			->where([
				'email' => $request['email'],
				'token' => $request->token,
			])
			->first();

		if (!$updatePassword)
		{
			return response()->json('Something went wrong!', 400);
		}

		$user = User::where('email', $request['email'])->first();

		if (Hash::check($request['password'], $user->password))
		{
			return response()->json('new password must differ from old one !', 400);
		}

		User::where('email', $request['email'])
			->update(['password' => Hash::make($request['password'])]);

		return response()->json('Password updated successfully!');
	}
}
