<?php

namespace app\controllers;

use yii\web\controller;
use app\models\repository\Users;

class TaskController extends Controller
{
  public function actionIndex()
  {
    return $this->render('index', array("title" => "Урок 1", "description" => "Контроллер Task"));
  }
}
