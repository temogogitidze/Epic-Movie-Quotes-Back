<?php

namespace App\Http\Controllers\Likes;

use App\Events\QuoteLiked;
use App\Http\Controllers\Controller;
use App\Http\Requests\LikeRequests\LikeQuoteRequest;
use App\Models\Like;
use App\Models\Notification;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
	public function like(LikeQuoteRequest $request): JsonResponse
	{
		$attributes = [
			'quote_id' => $request['quote_id'],
			'like'     => $request['like'],
		];

		$userId = jwtUser()->id;

		$attributes['user_id'] = $userId;
		$attributes['username'] = jwtUser()->username;

		$user = User::where('id', $userId)->first();

		$isLiked = $user->likes()->where('quote_id', $attributes['quote_id'])->first();

		if (!$isLiked)
		{
			Like::create($attributes);

			$quote = Quote::where('id', $request['quote_id'])->first();

			$quoteAuthorId = $quote->user_id;

			if (jwtUser()->id !== $quoteAuthorId)
			{
				$notification = new Notification();
				$notification->from = jwtUser()->id;
				$notification->to = $quoteAuthorId;
				$notification->type = 'like';
				$notification->save();
				event((new QuoteLiked($notification->load('sender'))));
			}

			return response()->json('liked');
		}
		else
		{
			$isLiked->delete();
			$notification = Notification::latest()->where('type', 'like')->first();
			$notification->delete();
			return response()->json('like deleted');
		}
	}

	public function likeable(Quote $quote): JsonResponse
	{
		$like = Like::where('user_id', jwtUser()->id)->where('quote_id', $quote->id)->first();

		return response()->json(['likeable' => $like ? false : true]);
	}
}
