<?php

namespace app\models\events;

use yii\base\Event;

class TaskCreateEvents extends Event
{
  public static function sendEmailNewTask($user, $model)
  {
    $message = 'Hello friend' . "\n\r";
    $message .= 'New task for you!' . "\n\r";
    $message .= 'Name: ' . $model->name . "\n\r";
    $message .= 'Description: ' . $model->description . "\n\r";
    $message .= 'Deadline: ' . $model->deadline . "\n\r";

    mail($user->id, 'New task for you', $message);
  }
}