<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\repository\Tasks */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tasks-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
        ],
    ]) ?>

</div>
