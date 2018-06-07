<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

$this->title = 'My tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-tasks-index">

  <h1><?= Html::encode($this->title) ?></h1>
    <table class="table table-bordered">
      <thead>
      <tr>
        <th class="bg-success">Day</th>
        <th>Tasks</th>
      </tr>
      </thead>
      <tbody>
        <?php
        foreach ($calendar as $day => $model) {
          echo '<tr>';
          echo '<th class="bg-success">' . $day . '</th>';
          echo '<th>';
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
                  'description:html',
                  'autor_id' => [
                      'attribute' => 'autor_id',
                      'value' => function ($model) {
                        $user = $model->getAutor()->where(['id' => $model->autor_id])->one();
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
          echo '</th>';
          echo '</tr>';
        }
        ?>
      </tbody>
    </table>
</div>
