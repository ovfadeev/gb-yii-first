<?php

namespace app\controllers;

use Yii;
use app\models\repository\Tasks;
use app\models\repository\StatusTasks;
use app\models\repository\Users;
use yii\data\ActiveDataProvider;

class MyTasksController extends \yii\web\Controller
{
  public function actionIndex()
  {
    $model = Tasks::find()
        ->where([
            'performer_id' => Yii::$app->user->identity->id
        ])
        ->andWhere([
            'MONTH(date_create)' => date('n')
        ])
        ->andWhere([
            'YEAR(date_create)' => date('Y')
        ]);

    $dataProvider = new ActiveDataProvider([
        'query' => $model,
        'pagination' => ['pageSize' => 10],
    ]);

    return $this->render('index', [
        'model' => $model,
        'dataProvider' => $dataProvider
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
