<?php

namespace TaskForce\Classes;

use Exceptions\ActionException;
use TaskForce\Classes\Actions\ActionCancel;
use TaskForce\Classes\Actions\ActionRespond;
use TaskForce\Classes\Actions\ActionStart;
use TaskForce\Classes\Actions\ActionDone;
use TaskForce\Classes\Actions\ActionRefuse;

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

    public $status;
    public $customerId;
    public $executorId;

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
            self::ACTION_RESPOND => self::STATUS_NEW,
            self::ACTION_START => self::STATUS_IN_WORK,
            self::ACTION_DONE => self::STATUS_DONE,
            self::ACTION_REFUSE => self::STATUS_FAILED,
        ];

        if (!isset($availableStatusesArray[$action])) {
            throw new ActionException("Action не может иметь такое значение");
        }

        return $availableStatusesArray[$action];
    }

    public function getAvailableActions(int $currentUserId): array
    {
        $availableActions = [];

        if (ActionCancel::isAvailable($this, $currentUserId)) {
            $availableActions[] = new ActionCancel();
        }

        if (ActionRespond::isAvailable($this, $currentUserId)) {
            $availableActions[] = new ActionRespond();
        }

        if (ActionStart::isAvailable($this, $currentUserId)) {
            $availableActions[] = new ActionStart();
        }

        if (ActionDone::isAvailable($this, $currentUserId)) {
            $availableActions[] = new ActionDone();
        }

        if (ActionRefuse::isAvailable($this, $currentUserId)) {
            $availableActions[] = new ActionRefuse();
        }

        return $availableActions;
    }
}
