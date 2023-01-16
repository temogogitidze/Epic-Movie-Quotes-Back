<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class EmailVerificationController extends Controller
{
	public function verifyUser($token): JsonResponse
	{
		$user = User::where('token', $token)->first();

		$user->markEmailAsVerified();

		return response()->json('Email verified successfully !');
	}
}
