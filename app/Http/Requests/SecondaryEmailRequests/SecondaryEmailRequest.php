<?php

namespace App\Http\Requests\SecondaryEmailRequests;

use Illuminate\Foundation\Http\FormRequest;

class SecondaryEmailRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules()
	{
		return [
			'email' => 'required|unique:users,email|unique:emails,email',
		];
	}
}
