<?php

namespace TaskForce\Classes\Actions;

use TaskForce\Classes\Task;

abstract class AbstractAction
{
    protected string $title;
    protected string $name;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getName(): string
    {
        return $this->name;
    }

    abstract public static function isAvailable(Task $task, int $currentUserId): bool;
}
