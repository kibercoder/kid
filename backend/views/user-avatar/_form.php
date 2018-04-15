<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserAvatar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-avatar-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_a')->textInput() ?>

    <?= $form->field($model, 'id_u')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
