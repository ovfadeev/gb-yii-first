<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

$this->title = 'My tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-tasks-index">

  <h1><?= Html::encode($this->title) ?></h1>
  <div class="row">
    <?php
    foreach ($calendar as $day => $model) {
      echo '<div class="col-lg-1 alert-success">' . $day . '</div>';
      echo '<div class="col-lg-11">';
      $dataProvider = new ActiveDataProvider([
          'query' => $model
      ]);
      echo GridView::widget([
          'dataProvider' => $dataProvider,
          'filterModel' => $searchModel,
          'columns' => [
              ['class' => 'yii\grid\SerialColumn'],

              'id',
              'name',
              'deadline',
              'description:ntext',
              'autor_id' => [
                  'attribute' => 'autor_id',
                  'value' => function ($model) {
                    $user = $model->getAutor()->where(['id' => $model->autor_id])->one();
                    return $user->getFullName();
                  }
              ],
              'performer_id' => [
                  'attribute' => 'performer_id',
                  'value' => function ($model) {
                    $user = $model->getPerformer()->where(['id' => $model->performer_id])->one();
                    return $user->getFullName();
                  }
              ],
              'status_id' => [
                  'attribute' => 'status_id',
                  'value' => function ($model) {
                    $status = $model->getStatus()->where(['id' => $model->status_id])->one();
                    return $status->title;
                  }
              ],

              [
                  'class' => 'yii\grid\ActionColumn',
                  'visibleButtons' => [
                      'delete' => false
                  ]
              ],
          ],
      ]);
      echo '</div>';
    }
    ?>
  </div>
</div>
