<?php

namespace app\controllers;

use yii\web\controller;
use app\models\repository\Tasks;

class TaskController extends Controller
{
  public function actionIndex()
  {
    return $this->render('index', ["title" => "Урок 1", "description" => "Контроллер Task"]);
  }

  public function actionCreate()
  {
    $tasks = new Tasks();
    return $this->render('create', ['model' => $tasks]);
  }
}
