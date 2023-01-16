<?php

namespace App\Http\Requests\UserRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules()
	{
		return [
			'username' => 'required|unique:users,username,' . jwtUser()->id,
			'email'    => 'required|email|unique:users,email,' . jwtUser()->id,
		];
	}
}
