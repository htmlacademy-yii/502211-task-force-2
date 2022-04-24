<?php

namespace TaskForce\Classes\Actions;

use TaskForce\Classes\Task;

class ActionRefuse extends AbstractAction
{
    protected string $title = 'Отказаться';
    protected string $name = 'refuse';

    public static function isAvailable(Task $task, int $currentUserId): bool
    {
        if ($task->status !== Task::STATUS_IN_WORK) {
            return false;
        }

        return $currentUserId === $task->executorId;
    }
}
