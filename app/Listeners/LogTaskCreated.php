<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use Illuminate\Support\Facades\Log;

class LogTaskCreated
{
    public function handle(TaskCreated $event): void
    {
        Log::info(
            'New Task Created: ' . $event->task->title
        );
    }
}