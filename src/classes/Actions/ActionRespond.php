<?php

namespace TaskForce\Classes\Actions;

use TaskForce\Classes\Task;

class ActionRespond extends AbstractAction
{
    protected string $title = 'Откликнуться';
    protected string $name = 'respond';

    public static function isAvailable(Task $task, int $currentUserId): bool
    {
        if ($task->status !== Task::STATUS_NEW) {
            return false;
        }

        if ($currentUserId !== $task->customerId && $currentUserId !== $task->executorId) {
            return true;
        }
    }
}
