<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
	public function index()
	{
		return response()->json(Notification::where('to', jwtUser()->id)->with('sender')->orderBy('created_at', 'desc')->get());
	}

	public function unread()
	{
		return response()->json(Notification::where('to', '=', jwtUser()->id)->where('read', '=', 0)->count());
	}

	public function mark()
	{
		$notification = Notification::where('read', '=', 0);

		$notification->update(['read' => 1]);

		$allNotifications = Notification::latest()->where('to', jwtUser()->id)->with('sender')->get();

		return response()->json($allNotifications, 200);
	}
}
