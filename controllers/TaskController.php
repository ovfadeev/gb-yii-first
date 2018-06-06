<?php

namespace app\controllers;

use Yii;
use yii\web\controller;
use app\models\repository\Tasks;
use app\models\repository\Users;
use app\models\Role;

class TaskController extends Controller
{
  public function actionIndex()
  {
    return $this->render('index', ["title" => "Урок 1", "description" => "Контроллер Task"]);
  }

  public function actionCreate()
  {
    $roleAdmin = Role::getIdAdminRole();

    $curUserId = Yii::$app->user->identity->id;

    $tasks = new Tasks();
    $tasks->autor_id = $curUserId;

    $users = Users::find()->where('role_id != :role_id',[':role_id' => $roleAdmin->id])->all();

    return $this->render('create', ['model' => $tasks, 'users' => $users]);
  }
}
