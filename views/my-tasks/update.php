<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\repository\Tasks */

$this->title = 'Update my tasks: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'My tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tasks-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'users' => $users,
        'status' => $status
    ]) ?>

</div>
