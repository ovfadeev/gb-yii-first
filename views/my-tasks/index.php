<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\models\repository\Tasks;

$langFile = 'app_my_tasks';

$this->title = Yii::t($langFile, 'page_title');
$this->params['breadcrumbs'][] = Yii::t($langFile, 'page_title');

$paramsCache = [
    'duration' => Yii::$app->params['cache_time'],
    'dependency' => [
        'class' => 'yii\caching\DbDependency',
        'sql' => Tasks::find()
            ->select('MAX(date_update)')
            ->where(['performer_id' => $data['user']])
            ->limit('1')
            ->prepare(Yii::$app->db->queryBuilder)
            ->createCommand()
            ->getRawSql()
    ],
    'enabled' => true,
    'variations' => [
        $data['user'],
        $data['cur_year'],
        $data['cur_month']
    ]
];

if ($this->beginCache('usertask', $paramsCache)) { ?>
  <div class="my-tasks-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <table class="table table-bordered">
      <thead>
      <tr>
        <th class="bg-success">
          <?= Yii::t($langFile, 'table_header_day')?>
        </th>
        <th>
          <?= Yii::t($langFile, 'table_header_tasks')?>
        </th>
      </tr>
      </thead>
      <tbody>
      <?php
      foreach ($data['calendar'] as $day => $model) {
        echo '<tr>';
        echo '<th class="bg-success">' . $day . '</th>';
        echo '<th>';
        $dataProvider = new ActiveDataProvider([
            'query' => $model
        ]);

        echo GridView::widget([
            'dataProvider' => $dataProvider,
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
                        'delete' => Yii::$app->user->can('deleteTask')
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
  <?php

  $this->endCache();
}