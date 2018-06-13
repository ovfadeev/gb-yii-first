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
  <?php if ($listComments) { ?>
    <?php foreach ($listComments as $key => $comment) { ?>
      <?
        echo '<pre>';
        print_r($comment);
      echo '</pre>';
      ?>
      <table class="table table-bordered">
        <tbody>
        <tr>
          <td>
            <?= $comment['id'] ?>
          </td>
          <td>
            Автор: <?= $comment['autor'] ?>
          </td>
          <td>
            <?= $comment['date_update'] ?>
          </td>
        </tr>
        <tr>
          <td colspan="3">
            <?= $comment['text'] ?>
          </td>
        </tr>
        <tr>
          <td colspan="3">
            <? if ($comment['file']['type'] == 'image/jpeg') { ?>
              <img src="<?= $comment['file']['resize'] . $comment['file']['title'] ?>" alt=""/>
            <? } else { ?>
              <a href="<?= $comment['file']['path'] . $comment['file']['title'] ?>"><?= $comment['file']['title'] ?></a>
            <? } ?>
          </td>
        </tr>
        </tbody>
      </table>
    <? } ?>
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
