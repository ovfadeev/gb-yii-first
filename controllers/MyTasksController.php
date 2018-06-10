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
    return $this->render('index', [
        'data' => $this->getCalendar()
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

  protected function getCalendar()
  {
    $params = [
        'user' => Yii::$app->user->identity->id,
        'calendar' => array_fill_keys(range(1, date("t")), []),
        'cur_year' => date("Y"),
        'cur_month' => date("m")
    ];

    foreach ($params['calendar'] as $day => $value) {
      $params['calendar'][$day] = Tasks::getTasksDeadlineOnDays(
          $params['user'],
          $day,
          $params['cur_month'],
          $params['cur_year']
      );
    }

    return $params;
  }

}
