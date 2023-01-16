<?php

namespace App\Http\Controllers\SecondaryEmails;

use App\Http\Controllers\Controller;
use App\Http\Requests\SecondaryEmailRequests\SecondaryEmailRequest;
use App\Mail\VerifySecondaryEmail;
use App\Models\Email;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SecondaryEmailsController extends Controller
{
	public function store(Request $request): JsonResponse
	{
		$attributesForUpdate = ['email' => $request['email']];

		Email::create(['email' => jwtUser()->email, 'user_id' => jwtUser()->id]);

		$oldPrimaryEmail = Email::where('email', $request['email'])->first();

		$oldPrimaryEmail->delete();

		$user = User::where('id', jwtUser()->id);

		$user->update($attributesForUpdate);

		Mail::to(jwtUser()->email)->send(new VerifySecondaryEmail(jwtUser()));

		return response()->json('success');
	}

	public function addSecondaryEmail(SecondaryEmailRequest $request): JsonResponse
	{
		Email::create(['email' => $request['email'], 'user_id' => jwtUser()->id]);

		return response()->json('success');
	}

	public function get(): JsonResponse
	{
		$secondaryEmails = Email::where('user_id', jwtUser()->id)->get();

		return response()->json($secondaryEmails);
	}

	public function destroy($secondaryEmailId): JsonResponse
	{
		$secondaryEmail = Email::where('id', $secondaryEmailId);

		$secondaryEmail->delete();

		return response()->json('Secondary email deleted');
	}
}
