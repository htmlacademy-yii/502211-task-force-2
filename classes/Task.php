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

    private $status;
    private $currentId;
    private $customerId;
    private $executorId;

    public function __construct($status, $customer = null, $executor, $current)
    {
        $this->status = $status;
        $this->customerId = $customer;
        $this->executorId = $executor;
        $this->currentId = $current;
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
            self::ACTION_DONE => 'Выполнено',
            self::ACTION_REFUSE => 'Отказаться',
        ];
    }

    public function getNextStatusByAction($action)
    {
        $statusByActionArray = [
            self::ACTION_CANCEL => self::STATUS_CANCELED,
            self::ACTION_RESPOND => self::STATUS_IN_WORK,
            self::ACTION_DONE => self::STATUS_DONE,
            self::ACTION_REFUSE => self::STATUS_FAILED,
        ];

        return $statusByActionArray[$action] ?? null;
    }
}
