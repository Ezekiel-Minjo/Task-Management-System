<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function index($userId)
    {
        return Notification::where('user_id', $userId)
            ->where('read', false)
            ->get();
    }
}
