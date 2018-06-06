<?php

namespace app\controllers;

use Yii;
use app\models\repository\Tasks;
use yii\data\ActiveDataProvider;

class MyTasksController extends \yii\web\Controller
{
  public function actionIndex()
  {
    $model = Tasks::find();

    $dataProvider = new ActiveDataProvider([
        'query' => $model,
        'pagination' => array('pageSize' => 10),
    ]);

    $beginCurMonth = mktime(0, 0, 0, date('m'), 1, date("Y"));
    $endCurMonth = mktime(0, 0, 0, date('m'), date('t'), date("Y"));

    $dataProvider->query
        ->andFilterWhere([
            'in',
            'id',
            Yii::$app->user->identity->id
        ])
        ->andFilterWhere([
            'between',
            'date_create',
            date('Y-m-d H:i:s', $beginCurMonth),
            date('Y-m-d H:i:s', $endCurMonth)
        ]);

    return $this->render('index', [
        'model' => $model,
        'dataProvider' => $dataProvider
    ]);
  }

}
