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

    $dataProvider->query->andFilterWhere([
        'in',
        'id',
        Yii::$app->user->identity->id
    ])/*->andFilterWhere([
        'in',
        'date_create',
        date('Y-m-d H:i:s', strtotime("+7 days", time())),
//        date('Y-m-d H:i:s', strtotime("-1 month +7 days", time()))
    ])*/;

    return $this->render('index', [
        'model' => $model,
        'dataProvider' => $dataProvider
    ]);
  }

}
