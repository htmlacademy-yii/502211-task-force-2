<?php

namespace TaskForce\Classes\Actions;

class ActionStart extends Action
{
    public function getTitle(): string
    {
        return 'Запуск';
    }

    public function getName(): string
    {
        return 'start';
    }

    public function getRights(int $customerId, int $executorId, int $currentId): bool
    {
        return $this->currentId === $this->customerId;
    }
}
