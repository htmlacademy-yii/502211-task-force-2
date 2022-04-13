<?php

namespace TaskForce\Classes\Actions;

class ActionRefuse extends Action
{
    public function getTitle(): string
    {
        return 'Отказаться';
    }

    public function getName(): string
    {
        return 'refuse';
    }

    public function getRights(int $customerId, int $executorId, int $currentId): bool
    {
        return $this->currentId === $this->executorId;
    }
}
