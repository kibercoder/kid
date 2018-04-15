<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Avatar */
/* @var $form yii\widgets\ActiveForm */

$src = '/avatars/165x165/site/'.$model->avatar_name. '?get='.  time();

?>

<div class="avatar-form">
	
    <?php $form = ActiveForm::begin([
    		'id' => 'form-avatar',
            'options' => ['enctype'=>'multipart/form-data'],
            'enableAjaxValidation'   => true,
            'enableClientValidation' => true,
            'validateOnBlur'         => true,
            'validateOnType'         => true,
            'validateOnChange'       => true,
            'validateOnSubmit'       => true,
    ]); ?>

    <?=$form->field(
	        $model, 'avatar_name',
	        ['template' => '<div>{input}<br /><img src="'.$src.'" width="48" /></div>{hint}{error}']
		)->fileInput() 
    ?>

    <?= $form->field($model, 'gender')->dropDownList(['m' => 'Мужчина', 'w' => 'Женщина']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
