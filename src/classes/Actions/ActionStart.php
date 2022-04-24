<?php

namespace TaskForce\Classes\Actions;

use TaskForce\Classes\Task;

class ActionStart extends AbstractAction
{
    protected string $title = 'Запуск';
    protected string $name = 'start';

    public static function isAvailable(Task $task, int $currentUserId): bool
    {
        if ($task->status !== Task::STATUS_NEW) {
            return false;
        }

        return $currentUserId === $task->customerId;
    }
}
