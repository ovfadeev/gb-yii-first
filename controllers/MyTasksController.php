<?php

namespace app\controllers;

use Yii;
use app\models\repository\Tasks;
use app\models\repository\StatusTasks;
use app\models\repository\Users;

class MyTasksController extends \yii\web\Controller
{
  public function actionIndex()
  {
    $idUser = Yii::$app->user->identity->id;
    $calendar = array_fill_keys(range(1, date("t")), []);
    $curYear = date("Y");
    $curMonth = date("m");

    foreach ($calendar as $day => $value) {
      $calendar[$day] = Tasks::getTasksDeadlineOnDays($idUser, $day, $curMonth, $curYear);
    }

//    echo '<pre>';
//    print_r($calendar);
//    echo '</pre>';
//    exit();

    return $this->render('index', [
        'calendar' => $calendar
    ]);
  }

  public function actionView($id)
  {
    return $this->render('view', [
        'model' => $this->findModel($id),
    ]);
  }

  public function actionUpdate($id)
  {
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
    }

    $model->autor_id = Yii::$app->user->identity->id;

    $status = StatusTasks::find()->all();

    $users = Users::find()->all();

    return $this->render('update', [
        'model' => $model,
        'users' => $users,
        'status' => $status
    ]);
  }

  protected function findModel($id)
  {
    if (($model = Tasks::findOne($id)) !== null) {
      return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
  }

}
