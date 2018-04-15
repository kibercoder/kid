<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Avatar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="avatar-form">

    <?php $form = ActiveForm::begin([
            'id' => 'form-avatar',
            'options' => ['enctype'=>'multipart/form-data']
    ]); ?>

    <?=$form->field(
	        $model, 'avatar_name',
	        ['template' => '{input}{hint}{error}']
		)->fileInput() 
    ?>

    <?= $form->field($model, 'gender')->dropDownList(['m' => 'Мужчина', 'w' => 'Женщина']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
