<?php

namespace app\models\events;

use yii\base\Event;

class TaskCreateEvents extends Event
{
  public static function sendEmail($model)
  {
    $emailTo = self::getEmailTo($model->sender);
    $emailFrom = \Yii::$app->params['adminEmail'];
    $subject = \Yii::$app->params['createTask'];
    $message = static::mailMessage($model->sender);

    \Yii::$app->mailer->compose()
        ->setTo($emailTo)
        ->setFrom($emailFrom)
        ->setSubject($subject)
        ->setTextBody($message)
        ->send();
    // config web mailer on local server - 'useFileTransport' => false
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