<?php

namespace app\models\events;

use yii\base\Event;

class TaskCreateEvents extends Event
{
  const EVENT_CREATE_TASK = 'create_task';

  public static function sendEmail($model)
  {
    $emailTo = self::getEmailTo($model->sender);
    $emailFrom = 'info@site.ru';
    $subject = 'New task for you';
    $message = static::mailMessage($model->sender);

    \Yii::$app->mailer->compose()
        ->setTo($emailTo)
        ->setFrom($emailFrom)
        ->setSubject($subject)
        ->setTextBody($message)
        ->send();
  }

  protected function mailMessage($model)
  {
    $message = 'Hello friend :)' . "\n\r";
    $message .= 'New task for you!' . "\n\r";
    $message .= 'Name: ' . $model->name . "\n\r";
    $message .= 'Description: ' . $model->description . "\n\r";
    $message .= 'Deadline: ' . $model->deadline . "\n\r";

    return $message;
  }

  protected function getEmailTo($model)
  {
    return $model
        ->getPerformer()
        ->where(['id' => $model->performer_id])
        ->one()
        ->email;
  }
}