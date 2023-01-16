<?php

namespace App\Http\Requests\AuthRequests;

use App\Rules\LowerCase;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules()
	{
		return [
			'login'    => ['required', new LowerCase],
			'password' => 'required',
		];
	}

	public function messages()
	{
		return [
			'email.exists' => 'User does not exist!',
		];
	}
}
