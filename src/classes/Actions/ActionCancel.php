<?php

namespace TaskForce\Classes\Actions;

class ActionCancel extends Action
{
    public function getTitle(): string
    {
        return 'Отменить';
    }

    public function getName(): string
    {
        return 'cancel';
    }

    public function getRights(int $customerId, int $executorId, int $currentId): bool
    {
        return $this->currentId === $this->customerId;
    }
}
