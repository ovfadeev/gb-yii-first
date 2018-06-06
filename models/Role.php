<?php

namespace app\models;

class Role extends \yii\base\BaseObject
{
  public $id;
  public $title;

  public static function getIdAdminRole()
  {
    return \app\models\repository\Roles::find()->where(['title' => 'admin'])->one();
  }
}