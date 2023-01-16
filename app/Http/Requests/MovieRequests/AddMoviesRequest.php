<?php

namespace App\Http\Requests\MovieRequests;

use App\Rules\EnglishText;
use App\Rules\GeorgianText;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddMoviesRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules()
	{
		return [
			'name_en'        => ['required', new EnglishText, Rule::unique('movies', 'name')],
			'name_ka'        => ['required', new GeorgianText, Rule::unique('movies', 'name')],
			'genre'          => ['required'],
			'director_en'    => ['required', new EnglishText],
			'director_ka'    => ['required', new GeorgianText],
			'description_en' => ['required', new EnglishText],
			'description_ka' => ['required', new GeorgianText],
			'budget'         => 'required',
			'release_date'   => 'required',
			'thumbnail'      => 'required',
		];
	}

	public function messages()
	{
		return [
			'name_en.unique' => 'This movie already exists !',
			'name_ka.unique' => 'This movie already exists !',
		];
	}
}
