<?php
namespace Psli\Todo\Observers;


use Illuminate\Support\Facades\Notification;
use Psli\Todo\Models\UserTask;
use Psli\Todo\Notifications\TaskStatusChangedNotification;

class UserTaskObserver
{
    public function updating(UserTask $userTask)
    {
        if($userTask->isDirty('status') && $userTask->status === UserTask::STATUS[0]) {
            Notification::send($userTask->user, new TaskStatusChangedNotification($userTask));
        }
    }
}
