<?php

/* @var $this yii\web\View */

/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

$this->title = 'Create task';
$this->params['breadcrumbs'][] = $this->title;

echo '<pre>';
print_r($users);
echo '</pre>';

?>
<div class="create-task">
  <h1><?= Html::encode($this->title) ?></h1>

  <?php
  $form = ActiveForm::begin([
      'id' => 'create-task-form',
      'layout' => 'horizontal',
      'fieldConfig' => [
          'template' => "{label}\n<div class=\"col-lg-5\">{input}</div>\n<div class=\"col-lg-5\">{error}</div>",
          'labelOptions' => ['class' => 'col-lg-2 control-label'],
      ],
  ]);
  ?>

  <?= $form->field($model, 'autor_id', [
      'template' => '{input}'
  ])->textInput(['type' => 'hidden']) ?>

  <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

  <?= $form->field($model, 'deadline')->textInput(['type' => 'date']) ?>

  <?= $form->field($model, 'description')->textarea(['rows' => '6']) ?>

  <?= $form->field($model, 'performer_id')->dropDownList(ArrayHelper::map($users, 'id', 'first_name')) ?>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <?= Html::submitButton('Create', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>
    </div>
  </div>

  <?php ActiveForm::end(); ?>
</div>
