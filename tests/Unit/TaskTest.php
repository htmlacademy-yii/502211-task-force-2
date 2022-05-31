<?php

namespace Tests\Unit;

use Exceptions\Exception;
use PHPUnit\Framework\TestCase;
use TaskForce\Classes\Actions\ActionCancel;
use TaskForce\Classes\Actions\ActionDone;
use TaskForce\Classes\Actions\ActionRefuse;
use TaskForce\Classes\Actions\ActionRespond;
use TaskForce\Classes\Actions\ActionStart;
use TaskForce\Classes\Task;

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
        $this->assertEquals(Task::STATUS_NEW, $status);

        $task = new Task(Task::STATUS_NEW, $customerId);
        $status = $task->getStatusAfterAction(Task::ACTION_START);
        $this->assertEquals(Task::STATUS_IN_WORK, $status);

        $task = new Task(Task::STATUS_IN_WORK, $customerId);
        $status = $task->getStatusAfterAction(Task::ACTION_DONE);
        $this->assertEquals(Task::STATUS_DONE, $status);

        $task = new Task(Task::STATUS_IN_WORK, $customerId);
        $status = $task->getStatusAfterAction(Task::ACTION_REFUSE);
        $this->assertEquals(Task::STATUS_FAILED, $status);

        $task = new Task(Task::STATUS_NEW, $customerId);
        $status = $task->getStatusAfterAction('next');
        $this->assertEquals(new Exception, $status);
    }

    public function testGetAvailableActions()
    {
        $customerId = 1;
        $executorId = 2;
        $randomUserId = 3;

        $task = new Task(Task::STATUS_NEW, $customerId);
        $actions = $task->getAvailableActions($customerId);
        $this->assertEquals([new ActionCancel, new ActionStart], $actions);

        $task = new Task(Task::STATUS_NEW, $customerId);
        $actions = $task->getAvailableActions($randomUserId);
        $this->assertEquals([new ActionRespond], $actions);


        $task = new Task(Task::STATUS_CANCELED, $customerId);
        $actions = $task->getAvailableActions($customerId);
        $this->assertEquals([], $actions);

        $task = new Task(Task::STATUS_CANCELED, $customerId);
        $actions = $task->getAvailableActions($randomUserId);
        $this->assertEquals([], $actions);


        $task = new Task(Task::STATUS_IN_WORK, $customerId, $executorId);
        $actions = $task->getAvailableActions($customerId);
        $this->assertEquals([new ActionDone], $actions);

        $task = new Task(Task::STATUS_IN_WORK, $customerId, $executorId);
        $actions = $task->getAvailableActions($executorId);
        $this->assertEquals([new ActionRefuse], $actions);

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
