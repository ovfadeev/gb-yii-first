<?php

namespace app\commands;


use app\models\events\TaskDeadlineEvents;
use app\models\repository\Tasks;
use yii\console\Controller;

class TaskController extends Controller
{
  /**
   * Send email about tasks that are approaching the deadline
   */
  public function actionDeadline()
  {
    $model = Tasks::getTasksDeadlineExpiring();

    $taskGroup = $this->groupTasksByUser($model);

    $emailSend = TaskDeadlineEvents::sendEmail($taskGroup);

    echo 'Send email to - ' . implode(', ', $emailSend);
  }

  protected function groupTasksByUser($model)
  {
    foreach ($model as $task) {
      $group[$task->performer_id][] = $task;
    }
    return $group;
  }
}