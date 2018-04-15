<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TournamentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tournament-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_t') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'photo') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'cost') ?>

    <?php // echo $form->field($model, 'fund') ?>

    <?php // echo $form->field($model, 'first_place') ?>

    <?php // echo $form->field($model, 'second_place') ?>

    <?php // echo $form->field($model, 'third_place') ?>

    <?php // echo $form->field($model, 'date_begin') ?>

    <?php // echo $form->field($model, 'date_end') ?>

    <?php // echo $form->field($model, 'type_age') ?>

    <?php // echo $form->field($model, 'max_member') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
