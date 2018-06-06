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

    $formatDate = 'Y-m-d H:i:s';
    $beginCurMonth = mktime(0, 0, 0, date('m'), 1, date("Y"));
    $endCurMonth = mktime(23, 59, 59, date('m'), date('t'), date("Y"));

    $dataProvider->query
        ->andFilterWhere([
            'in',
            'id',
            Yii::$app->user->identity->id
        ])
        ->andFilterWhere([
            'between',
            'date_create',
            date($formatDate, $beginCurMonth),
            date($formatDate, $endCurMonth)
        ]);

    return $this->render('index', [
        'model' => $model,
        'dataProvider' => $dataProvider
    ]);
  }

}
