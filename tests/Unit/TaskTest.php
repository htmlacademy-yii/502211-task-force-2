<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Task;

require __DIR__ . '/../../classes/Task.php';

class TaskTest extends TestCase
{
    public function testGetStatusAfterAction()
    {
        $customerId = 1;

        $task = new Task(Task::STATUS_NEW, $customerId);
        $status = $task->getStatusAfterAction(Task::ACTION_CANCEL);
        $this->assertEquals(Task::STATUS_CANCELED, $status);

        $task = new Task(Task::STATUS_NEW, $customerId);
        $status = $task->getStatusAfterAction(Task::ACTION_RESPOND);
        $this->assertEquals(Task::ACTION_START, $status);

        $task = new Task(Task::STATUS_NEW, $customerId);
        $status = $task->getStatusAfterAction(Task::ACTION_START);
        $this->assertEquals(Task::STATUS_IN_WORK, $status);

        $task = new Task(Task::STATUS_IN_WORK, $customerId);
        $status = $task->getStatusAfterAction(Task::ACTION_DONE);
        $this->assertEquals(Task::STATUS_DONE, $status);

        $task = new Task(Task::STATUS_IN_WORK, $customerId);
        $status = $task->getStatusAfterAction(Task::ACTION_REFUSE);
        $this->assertEquals(Task::STATUS_FAILED, $status);
    }

    public function testGetAvailableActions()
    {
        $customerId = 1;
        $executorId = 2;
        $randomUserId = 3;

        $task = new Task(Task::STATUS_NEW, $customerId);
        $actions = $task->getAvailableActions($customerId);
        $this->assertEquals([Task::ACTION_CANCEL, Task::ACTION_START], $actions);

        $task = new Task(Task::STATUS_NEW, $customerId);
        $actions = $task->getAvailableActions($randomUserId);
        $this->assertEquals([Task::ACTION_RESPOND], $actions);


        $task = new Task(Task::STATUS_CANCELED, $customerId);
        $actions = $task->getAvailableActions($customerId);
        $this->assertEquals([], $actions);

        $task = new Task(Task::STATUS_CANCELED, $customerId);
        $actions = $task->getAvailableActions($randomUserId);
        $this->assertEquals([], $actions);


        $task = new Task(Task::STATUS_IN_WORK, $customerId, $executorId);
        $actions = $task->getAvailableActions($customerId);
        $this->assertEquals([Task::ACTION_DONE], $actions);

        $task = new Task(Task::STATUS_IN_WORK, $customerId, $executorId);
        $actions = $task->getAvailableActions($executorId);
        $this->assertEquals([Task::ACTION_REFUSE], $actions);

        $task = new Task(Task::STATUS_IN_WORK, $customerId, $executorId);
        $actions = $task->getAvailableActions($randomUserId);
        $this->assertEquals([], $actions);


        $task = new Task(Task::STATUS_DONE, $customerId, $executorId);
        $actions = $task->getAvailableActions($customerId);
        $this->assertEquals([], $actions);

        $task = new Task(Task::STATUS_DONE, $customerId, $executorId);
        $actions = $task->getAvailableActions($executorId);
        $this->assertEquals([], $actions);

        $task = new Task(Task::STATUS_DONE, $customerId, $executorId);
        $actions = $task->getAvailableActions($randomUserId);
        $this->assertEquals([], $actions);


        $task = new Task(Task::STATUS_FAILED, $customerId, $executorId);
        $actions = $task->getAvailableActions($customerId);
        $this->assertEquals([], $actions);

        $task = new Task(Task::STATUS_FAILED, $customerId, $executorId);
        $actions = $task->getAvailableActions($executorId);
        $this->assertEquals([], $actions);

        $task = new Task(Task::STATUS_FAILED, $customerId, $executorId);
        $actions = $task->getAvailableActions($randomUserId);
        $this->assertEquals([], $actions);
    }
}
