<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function index($userId)
    {
        // You can adjust this to get only unread, or all
        return Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function markAsRead($id)
{
    $notification = \App\Models\Notification::findOrFail($id);
    $notification->read = true;
    $notification->save();

    return response()->json(['message' => 'Notification marked as read']);
}

}
