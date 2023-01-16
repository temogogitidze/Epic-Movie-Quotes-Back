<?php

namespace App\Http\Controllers\Quotes;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuoteRequests\AddQuotesRequest;
use App\Http\Requests\QuoteRequests\EditQuoteRequest;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
	public function index(): JsonResponse
	{
		$quotes = Quote::latest()->with(['movie', 'user', 'comments', 'likes'])->paginate(2);

		return response()->json($quotes);
	}

	public function refresh(Request $request): JsonResponse
	{
		$quotes = Quote::take($request->count)->with(['movie', 'user', 'comments', 'likes'])->orderBy('created_at', 'desc')->get();

		return response()->json($quotes);
	}

	public function get($id): JsonResponse
	{
		$quote = Quote::where('id', $id)->with(['comments', 'likes'])->first();

		return response()->json($quote);
	}

	public function store(AddQuotesRequest $request): JsonResponse
	{
		$attributes = [
			'body' => [
				'en' => $request['body_en'],
				'ka' => $request['body_ka'],
			],
			'movie_id'  => $request['movie_id'],
			'thumbnail' => $request['thumbnail'] = $request->file('thumbnail')->store('thumbnails'),
		];

		$attributes['user_id'] = jwtUser()->id;

		$quote = Quote::create($attributes);

		if (!$quote)
		{
			return response()->json('Something went wrong', 422);
		}

		return response()->json($quote->load('user')->load('movie')->load('likes')->load('comments'), 200);
	}

	public function update(EditQuoteRequest $request, $quoteId): JsonResponse
	{
		$quote = Quote::where('id', $quoteId)->first();

		$attributes = [
			'body' => [
				'en' => $request['body_en'],
				'ka' => $request['body_ka'],
			],
		];

		if (isset($request['thumbnail']))
		{
			$attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
		}

		$quote->update($attributes);

		return response()->json($quote);
	}

	public function destroy($quoteId)
	{
		$quote = Quote::where('id', $quoteId);

		$quote->delete();

		return response()->json('Quote deleted successfully');
	}
}
