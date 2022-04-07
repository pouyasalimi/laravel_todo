<?php

namespace Psli\Todo\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Psli\Todo\Models\UserTask;

class TaskStatusChangedNotification extends Notification
{
    public $task;

    public function __construct(UserTask $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        Log::info("Task '{$this->task->title}' has closed.");

        return (new MailMessage)
            ->subject("Task '{$this->task->title}' has closed.")
            ->line("Task '{$this->task->title}' has closed.");
    }
}
