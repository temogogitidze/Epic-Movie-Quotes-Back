<?php

namespace App\Http\Controllers\Comments;

use App\Events\QuoteCommented;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequests\AddCommentRequest;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
	public function store(AddCommentRequest $request): JsonResponse
	{
		$attributes = [
			'quote_id' => $request['quote_id'],
			'body'     => $request['body'],
		];

		$attributes['user_id'] = jwtUser()->id;
		$attributes['username'] = jwtUser()->username;
		$attributes['thumbnail'] = jwtUser()->thumbnail;

		$comment = Comment::create($attributes);

		$quote = Quote::where('id', $request['quote_id'])->first();

		$quoteAuthorId = $quote->user_id;

		if (jwtUser()->id !== $quoteAuthorId)
		{
			$notification = new Notification();
			$notification->from = jwtUser()->id;
			$notification->to = $quoteAuthorId;
			$notification->type = 'comment';
			$notification->save();
			event((new QuoteCommented($notification->load('sender'))));
		}

		return response()->json($comment);
	}
}
