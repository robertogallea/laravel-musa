<?php

namespace App\Listeners;

use App\Events\PostCreated;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;

class PostSubscriber
{
    public function handlePostCreated(PostCreated $event)
    {
        Log::info('Hello subscriber');
    }

//    public function handlePostDeleted(PostDeleted $event)
//    {
//        // ToDo
//    }

    public function subscribe(Dispatcher $events)
    {
        return [
            PostCreated::class => 'handlePostCreated',
//            PostDeleted::class => 'handlePostDeleted',
        ];
    }
}
