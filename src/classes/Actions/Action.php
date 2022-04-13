<?php

namespace TaskForce\Classes\Actions;

abstract class Action
{
    abstract public function getTitle(): string;

    abstract public function getName(): string;

    abstract public function getRights(int $customerId, int $executorId, int $currentId): bool;
}
