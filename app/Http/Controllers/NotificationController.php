<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Notifications\TestNotification;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        return view('notifications.index', [
            'notifications' => $request->user()->notifications
        ]);
    }

    public function show(DatabaseNotification $notification)
    {
        // segno la notifica come letta
        $notification->markAsRead();


        // redirigo all'url contenuto nella notifica
        return redirect($notification->data['url']);



    }
}
