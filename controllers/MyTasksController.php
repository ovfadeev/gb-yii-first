<?php

namespace app\controllers;

use Yii;
use app\models\repository\Tasks;
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

}
