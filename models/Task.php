<?php

namespace app\models;


class Task extends \yii\base\BaseObject
{
  public $id;
  public $name;
  public $date_create;
  public $date_update;
  public $deadline;
  public $description;
  public $autor_id;
  public $performer_id;
  public $status_id;

}