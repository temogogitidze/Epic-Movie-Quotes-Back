<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequests\UpdateUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
	public function update(UpdateUserRequest $request): JsonResponse
	{
		$attributes = [
			'username' => $request['username'],
			'email'    => $request['email'],
		];

		if (isset($request['thumbnail']))
		{
			$attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
		}

		if (isset($request['password']))
		{
			$attributes['password'] = Hash::make($request['password']);
		}

		jwtUser()->update($attributes);

		return response()->json('success');
	}
}
