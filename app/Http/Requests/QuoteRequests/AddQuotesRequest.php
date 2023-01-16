<?php

namespace App\Http\Requests\QuoteRequests;

use App\Rules\EnglishText;
use App\Rules\GeorgianText;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddQuotesRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules()
	{
		return [
			'body_en'   => ['required', new EnglishText, Rule::unique('quotes', 'body')],
			'body_ka'   => ['required', new GeorgianText, Rule::unique('quotes', 'body')],
			'movie_id'  => 'required',
			'thumbnail' => 'required',
		];
	}
}
