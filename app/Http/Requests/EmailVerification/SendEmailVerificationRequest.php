<?php

namespace App\Http\Requests\EmailVerification;

use Illuminate\Foundation\Http\FormRequest;

class SendEmailVerificationRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules()
	{
		return [
			'email' => 'required|email|exists:users',
		];
	}

	public function messages()
	{
		return [
			'email.exists' => 'User does not exist!',
		];
	}
}
