<?php

namespace TaskForce\Classes\Actions;

class ActionDone extends Action
{
    public function getTitle(): string
    {
        return 'Выполнено';
    }

    public function getName(): string
    {
        return 'done';
    }

    public function getRights(int $customerId, int $executorId, int $currentId): bool
    {
        return $this->currentId === $this->customerId;
    }
}
