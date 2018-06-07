<?php

namespace app\models\events;

use yii\base\Event;

class TaskCreateEvents extends Event
{
  const EVENT_CREATE_TASK = 'create_task';

  public static function sendEmail($model)
  {
    $performerUser = $model
        ->sender
        ->getPerformer()
        ->where(['id' => $model->sender->performer_id])
        ->one();

    mail(
        $performerUser->email,
        'New task for you',
        static::mailMessage($model->sender)
    );
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
}