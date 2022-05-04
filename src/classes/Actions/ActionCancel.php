<?php

namespace TaskForce\Classes\Actions;
use TaskForce\Classes\Task;

class ActionCancel extends AbstractAction
{
    protected string $title = 'Отменить';
    protected string $name = 'cancel';

    public static function isAvailable(Task $task, int $currentUserId): bool
    {
        if ($task->status !== Task::STATUS_NEW) {
            return false;
        }

        return $currentUserId === $task->customerId;
    }
}
