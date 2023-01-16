<?php

namespace App\Http\Requests\QuoteRequests;

use App\Rules\EnglishText;
use App\Rules\GeorgianText;
use Illuminate\Foundation\Http\FormRequest;

class EditQuoteRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules()
	{
		return [
			'body_en'   => ['required', new EnglishText],
			'body_ka'   => ['required', new GeorgianText],
			'thumbnail' => '',
		];
	}
}
