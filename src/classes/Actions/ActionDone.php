<?php

namespace TaskForce\Classes\Actions;

use TaskForce\Classes\Task;

class ActionDone extends AbstractAction
{
    protected string $title = 'Выполнено';
    protected string $name = 'done';

    public static function isAvailable(Task $task, int $currentUserId): bool
    {
        if ($task->status !== Task::STATUS_IN_WORK) {
            return false;
        }

        return $currentUserId === $task->customerId;
    }
}
