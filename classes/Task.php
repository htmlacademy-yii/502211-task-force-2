<?php

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
    const ACTION_CHOOSE_EXECUTOR = 'choose executor';

    private $status;
    private $customerId;
    private $executorId;

    public function __construct($status, $customer, $executor = null)
    {
        $this->status = $status;
        $this->customerId = $customer;
        $this->executorId = $executor;
    }

    public function getStatusMap()
    {
        return [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCELED => 'Отменено',
            self::STATUS_IN_WORK => 'В работе',
            self::STATUS_DONE => 'Выполнено',
            self::STATUS_FAILED => 'Провалено',
        ];
    }

    public function getActionMap()
    {
        return [
            self::ACTION_CANCEL => 'Отменить',
            self::ACTION_RESPOND => 'Откликнуться',
            self::ACTION_CHOOSE_EXECUTOR => 'Выбрать исполнителя',
            self::ACTION_DONE => 'Выполнено',
            self::ACTION_REFUSE => 'Отказаться',
        ];
    }

    public function getAvailableStatuses($action)
    {
        $availableStatusesArray = [
            self::ACTION_CANCEL => self::STATUS_CANCELED,
            self::ACTION_RESPOND => self::ACTION_CHOOSE_EXECUTOR,
            self::ACTION_CHOOSE_EXECUTOR => self::STATUS_IN_WORK,
            self::ACTION_DONE => self::STATUS_DONE,
            self::ACTION_REFUSE => self::STATUS_FAILED,
        ];

        return $availableStatusesArray[$action] ?? null;
    }

    public function getAvailableActions($status, $currentId, $customerId, $executorId)
    {
        $availableCustomerActionsArray = [
            self::STATUS_NEW => [
                self::ACTION_CANCEL,
                self::ACTION_CHOOSE_EXECUTOR,
            ],
            self::STATUS_CANCELED => null,
            self::STATUS_IN_WORK => self::ACTION_DONE,
            self::STATUS_DONE => null,
            self::STATUS_FAILED => null,
        ];

        $availableExecutorActionsArray = [
            self::STATUS_NEW => self::ACTION_RESPOND,
            self::STATUS_CANCELED => null,
            self::STATUS_IN_WORK => self::ACTION_REFUSE,
            self::STATUS_DONE => null,
            self::STATUS_FAILED => null,
        ];

        return $currentId === $customerId ? $availableCustomerActionsArray[$status] : $availableExecutorActionsArray[$status];
    }
}
