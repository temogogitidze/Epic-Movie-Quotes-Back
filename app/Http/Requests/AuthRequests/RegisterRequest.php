<?php

namespace App\Http\Requests\AuthRequests;

use App\Rules\LowerCase;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'username' => ['required', 'unique:users,username', 'min:3', 'max:15', new LowerCase],
			'email'    => 'required|unique:users,email|email',
			'password' => 'required',
		];
	}

	public function messages()
	{
		return [
			'username.required' => 'Username is required !',
			'email.required'    => 'Email is required !',
			'password.required' => 'Password is required !',
		];
	}
}
