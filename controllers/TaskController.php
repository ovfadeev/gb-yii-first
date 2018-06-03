<?php

namespace app\controllers;

use yii\web\controller;

class TaskController extends Controller
{
  public function actionIndex()
  {
    return $this->render('index', array("title" => "Урок 1", "description" => "Контроллер Task"));
  }
}
