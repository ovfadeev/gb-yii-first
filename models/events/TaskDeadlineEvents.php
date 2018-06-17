<?php

namespace app\models\events;

use app\models\repository\Users;
use Yii;
use yii\base\Event;

class TaskDeadlineEvents extends Event
{
  public static function sendEmail($taskGroup)
  {
    $emails = [];
    foreach ($taskGroup as $idUser => $group) {
      $emailTo = self::getEmailTo($idUser);
      Yii::$app->mailer->compose()
          ->setTo($emailTo)
          ->setFrom(Yii::$app->params['admin_email'])
          ->setSubject(Yii::$app->params['deadline_task'])
          ->setTextBody(self::prepareMessage($group))
          ->send();
      $emails[] = $emailTo;
    }
    return $emails;
  }

  protected function prepareMessage($group)
  {
    $message = 'Hello!' . "\n\r";
    $message .= 'List tasks deadline expiring:' . "\n\r";
    foreach ($group as $task) {
      $message .= $task->id . ' - ' . $task->name . "\n\r";
    }

    return $message;
  }

  protected function getEmailTo($idUser)
  {
    return Users::findOne($idUser)->email;
  }
}