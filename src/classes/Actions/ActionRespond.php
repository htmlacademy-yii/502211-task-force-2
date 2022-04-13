<?php

namespace TaskForce\Classes\Actions;

class ActionRespond extends Action
{
    public function getTitle(): string
    {
        return 'Откликнуться';
    }

    public function getName(): string
    {
        return 'respond';
    }

    public function getRights(int $customerId, int $executorId, int $currentId): bool
    {
        return $currentId !== $this->customerId && $currentId !== $this->executorId;
    }
}
