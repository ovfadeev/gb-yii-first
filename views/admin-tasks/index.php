<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\repository\TasksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tasks-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tasks', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'date_create',
            'date_update',
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
