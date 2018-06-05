<?php

namespace app\controllers;

use Yii;
use yii\web\controller;
use app\models\repository\Tasks;
use app\models\repository\Users;

class TaskController extends Controller
{
  public function actionIndex()
  {
    return $this->render('index', ["title" => "Урок 1", "description" => "Контроллер Task"]);
  }

  public function actionCreate()
  {
    $roleAdmin = 1;

    $curUserId = Yii::$app->user->identity->id;

    $tasks = new Tasks();
    $tasks->autor_id = $curUserId;

    $users = Users::find()->where('role_id != :role_id',[':role_id' => $roleAdmin])->all();

    return $this->render('create', ['model' => $tasks, 'users' => $users]);
  }
}
