<?php

namespace TaskForce\Classes;
use TaskForce\Classes\Actions;

class Task
{
    const STATUS_NEW = 'new';
    const STATUS_CANCELED = 'canceled';
    const STATUS_IN_WORK = 'in_work';
    const STATUS_DONE = 'done';
    const STATUS_FAILED = 'failed';

    const ACTION_CANCEL = 'cancel';
    const ACTION_RESPOND = 'respond';
    const ACTION_DONE = 'done';
    const ACTION_REFUSE = 'refuse';
    const ACTION_START = 'start';

    private $status;
    private $customerId;
    private $executorId;

    public function __construct(string $status, int $customerId, ?int $executorId = null)
    {
        $this->status = $status;
        $this->customerId = $customerId;
        $this->executorId = $executorId;
    }

    public function getStatusMap(): array
    {
        return [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCELED => 'Отменено',
            self::STATUS_IN_WORK => 'В работе',
            self::STATUS_DONE => 'Выполнено',
            self::STATUS_FAILED => 'Провалено',
        ];
    }

    public function getActionMap(): array
    {
        return [
            self::ACTION_CANCEL => 'Отменить',
            self::ACTION_RESPOND => 'Откликнуться',
            self::ACTION_START => 'Запуск',
            self::ACTION_DONE => 'Выполнено',
            self::ACTION_REFUSE => 'Отказаться',
        ];
    }

    public function getStatusAfterAction(string $action): ?string
    {
        $availableStatusesArray = [
            self::ACTION_CANCEL => self::STATUS_CANCELED,
            self::ACTION_RESPOND => self::ACTION_START,
            self::ACTION_START => self::STATUS_IN_WORK,
            self::ACTION_DONE => self::STATUS_DONE,
            self::ACTION_REFUSE => self::STATUS_FAILED,
        ];

        return $availableStatusesArray[$action] ?? null;
    }

    public function getAvailableActions(int $currentId): array
    {
        $availableCustomerActionsArray = [
            self::STATUS_NEW => [
                self::ACTION_CANCEL,
                self::ACTION_START,
            ],
            self::STATUS_CANCELED => [],
            self::STATUS_IN_WORK => [self::ACTION_DONE],
            self::STATUS_DONE => [],
            self::STATUS_FAILED => [],
        ];

        $availableExecutorActionsArray = [
            self::STATUS_NEW => [],
            self::STATUS_CANCELED => [],
            self::STATUS_IN_WORK => [self::ACTION_REFUSE],
            self::STATUS_DONE => [],
            self::STATUS_FAILED => [],
        ];

        $availableRandomUserActionsArray = [
            self::STATUS_NEW => [self::ACTION_RESPOND],
            self::STATUS_CANCELED => [],
            self::STATUS_IN_WORK => [],
            self::STATUS_DONE => [],
            self::STATUS_FAILED => [],
        ];

        if ($currentId === $this->customerId) {
            return $availableCustomerActionsArray[$this->status];
        }

        if ($currentId === $this->executorId) {
            return $availableExecutorActionsArray[$this->status];
        }

        if ($currentId !== $this->customerId && $currentId !== $this->executorId) {
            return $availableRandomUserActionsArray[$this->status];
        }

        return [];
    }
}
