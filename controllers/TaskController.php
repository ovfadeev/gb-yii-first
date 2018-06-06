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

  /**
   * @return string
   */
  public function actionCreate()
  {
    $model = new Tasks();

    if ($model->load(\Yii::$app->request->post()) && $model->save()) {
      $this->redirect(['task/index']);
    }

    $model->autor_id = Yii::$app->user->identity->id;

    $roleAdmin = Role::getIdAdminRole();
    $users = Users::find()->where('role_id != :role_id', [':role_id' => $roleAdmin->id])->all();

    return $this->render('create', ['model' => $model, 'users' => $users]);
  }
}
