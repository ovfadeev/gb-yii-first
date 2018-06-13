<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\repository\Tasks */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'My tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tasks-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
  <h3>Коментарии:</h3>
  <?php foreach ($listComments as $key => $comment) { ?>
    <table class="table table-bordered">
      <tbody>
      <tr>
        <td>
          <?= $comment->id ?>
        </td>
        <td>
          Автор: <?= $comment->autor_id ?>
        </td>
        <td>
          <?= $comment->date_update ?>
        </td>
      </tr>
      <tr>
        <td colspan="3">
          <?= $comment->text ?>
        </td>
      </tr>
      <tr>
        <td colspan="3">
          <?= $comment->file_id ?>
        </td>
      </tr>
      </tbody>
    </table>
  <? } ?>
  <p>
    Написать:
  </p>
  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($modelComment, 'task_id', [
      'template' => '{input}'
  ])->textInput(['type' => 'hidden']) ?>

  <?= $form->field($modelComment, 'autor_id', [
      'template' => '{input}'
  ])->textInput(['type' => 'hidden']) ?>

  <?= $form->field($modelComment, 'text')->textarea(['rows' => 6]) ?>

  <?= $form->field($modelFile, 'file')->fileInput() ?>

  <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
  </div>

  <?php ActiveForm::end(); ?>
</div>
