<?php
namespace App\Services;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskService extends Service
{
  private $taskModel;

  public function __construct(Task $taskModel)
  {
    $this->taskModel = $taskModel;
  }

  public function getFolderTasks(int $id)
  {
    return $this->taskModel->getFolderTasks($id);
  }

  public function createTask(int $id, Request $request)
  {
    return $this->taskModel->createTask($id, $request);
  }

  public function getTask(int $task_id)
  {
    return $this->taskModel->getTask($task_id);
  }

  public function editTask(Task $task, Request $request)
  {
    return $this->taskModel->editTask($task, $request);
  }
}