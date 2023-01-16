<?php

namespace App\Http\Requests\CommentRequests;

use Illuminate\Foundation\Http\FormRequest;

class AddCommentRequest extends FormRequest
{
	public function rules()
	{
		return [
			'quote_id' => 'required',
			'body'     => 'required',
		];
	}
}
