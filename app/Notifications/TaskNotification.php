<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TaskNotification extends Notification
{
    use Queueable;

    /**
     * Delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Data stored in notifications table.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'A new task has been assigned.',
            'task' => 'Laravel Learning',
        ];
    }
}