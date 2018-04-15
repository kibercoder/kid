<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Tournament */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tournament-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'photo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList([ 'individual' => 'Individual', 'team' => 'Team', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'cost')->textInput() ?>

    <?= $form->field($model, 'fund')->textInput() ?>

    <?= $form->field($model, 'first_place')->textInput() ?>

    <?= $form->field($model, 'second_place')->textInput() ?>

    <?= $form->field($model, 'third_place')->textInput() ?>

    <?= $form->field($model, 'date_begin')->textInput() ?>

    <?= $form->field($model, 'date_end')->textInput() ?>

    <?= $form->field($model, 'type_age')->dropDownList([ 1 => '1', 2 => '2', 3 => '3', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'max_member')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
