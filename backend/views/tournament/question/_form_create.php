<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

use yii\jui\AutoComplete;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\TournamentQuestion */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs(

	'$(function(){

		$("#tournamentquestion-type").change(function(){
				
			answerType = parseInt($("#tournamentquestion-type :selected").val());

			typeAge = $("#tournamentquestion-type_age").val();

			question = $("#tournamentquestion-question").val();


			var url_location = window.location.protocol+"//"+window.location.host+window.location.pathname;

				url_location+="?question="+question+"&type_age="+typeAge;

			switch (answerType) {
			  case 1:
				location.href = url_location+"&type-answer=1";
			  break;

			  case 2:
			  	location.href = url_location+"&type-answer=2";
			  break;

			  case 3:
			  	location.href = url_location+"&type-answer=3";
			  break;
			  default:

			}

	
		});


	});'

);


$get = Yii::$app->request->get();

$post = @Yii::$app->request->post()['TournamentQuestion'];

$arrTournaments = [];

foreach($tournaments as $val) {
	$arrTournaments[$val['id_t']] = $val['title'];
}

?>

<div class="tournament-question-form">

    <?php $form = ActiveForm::begin([
    	'options' => ['enctype'=>'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'question')->textInput([
    		'value' => (isset($post['question'])) ? $post['question'] : @$get['question']
    ])->label('Введите вопрос') ?>

	<?php

		$type_answer = [
			0 => '',
    		1 => 'В виде текстовых сообщений', 
    		2 => 'В виде картинок', 
    		3 => 'В виде карты'
	    ];


	    if (!empty($get['type-answer']) && is_numeric($get['type-answer'])) {
	    	$curent_answer = $type_answer[$get['type-answer']];
	    	unset($type_answer[0]);
	    	$model->type = $get['type-answer'];
	    }

	    if (!empty($get['type_age']) && is_numeric($get['type_age'])) {
	    	$model->type_age = $get['type_age'];
	    }

	?>

    <?= $form->field($model, 'type')->dropDownList(
    	$type_answer
    )->label('Выберете вариант ответа на вопрос') ?>


    <?= $form->field($model, 'type_age')->dropDownList([
    	1 => '6-8 лет', 2 => '9-12 лет', 3 => '13-15 лет'
	])->label('Выберете возраст') ?>


	<?php if (@$get['type-answer'] == 1) : ?>

		<?=$form->field(
	        $modelAnswerString, 'photo',
	        []
	    )->fileInput()->label('Фото для подсказки')
	    ?>

		<?= $form->field($modelAnswerString, 'answer1')->textInput(['value' => 'вариант1'])->label('Вариант ответа 1') ?>
		<?= $form->field($modelAnswerString, 'answer2')->textInput(['value' => 'вариант2'])->label('Вариант ответа 2') ?>
		<?= $form->field($modelAnswerString, 'answer3')->textInput(['value' => 'вариант3'])->label('Вариант ответа 3') ?>
		<?= $form->field($modelAnswerString, 'answer4')->textInput(['value' => 'вариант4'])->label('Вариант ответа 4') ?>

	    <?= $form->field($modelAnswerString, 'right_answer')->dropDownList([ 
	    		1 => '1', 
	    		2 => '2', 
	    		3 => '3',
	    		4 => '4'
	    ])->label('Укажите правильный ответ') ?>

	    <div class="form-group">
	        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
	    </div>

	<?php endif; ?>

	<?php if (@$get['type-answer'] == 2) : ?>
		
		<?=$form->field(
	        $modelAnswerPhoto, 'answerPhoto1',
	        []
	    )->fileInput()->label()
	    ?>

		<?=$form->field(
	        $modelAnswerPhoto, 'answerPhoto2',
	        []
	    )->fileInput()->label()
	    ?>

	    		<?=$form->field(
	        $modelAnswerPhoto, 'answerPhoto3',
	        []
	    )->fileInput()->label()
	    ?>

	    		<?=$form->field(
	        $modelAnswerPhoto, 'answerPhoto4',
	        []
	    )->fileInput()->label()
	    ?>

	    		<?=$form->field(
	        $modelAnswerPhoto, 'answerPhoto5',
	        []
	    )->fileInput()->label()
	    ?>

	    		<?=$form->field(
	        $modelAnswerPhoto, 'answerPhoto6',
	        []
	    )->fileInput()->label()
	    ?>

	    		<?=$form->field(
	        $modelAnswerPhoto, 'answerPhoto7',
	        []
	    )->fileInput()->label()
	    ?>

	    		<?=$form->field(
	        $modelAnswerPhoto, 'answerPhoto8',
	        []
	    )->fileInput()->label()
	    ?>

	    <?= $form->field($modelAnswerPhoto, 'right_answer')->dropDownList([ 
	    		1 => '1', 
	    		2 => '2', 
	    		3 => '3',
	    		4 => '4',
	    		5 => '5', 
	    		6 => '6', 
	    		7 => '7',
	    		8 => '8'
	    ])->label('Укажите правильный ответ') ?>

	    <div class="form-group">
	        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
	    </div>

	<?php endif; ?>

	<?php if (@$get['type-answer'] == 3) : ?>
		
		<?= $form->field($modelMap, 'country')->widget(\yii\jui\AutoComplete::classname(), [
			'value' => $modelMap->country,
			'class' => 'form-control',
		    'clientOptions' => [
		    'source' => $countryMap,
		    'minLength'=>'1',
		    'autoFill'=>true,
		    'select' => new JsExpression("function( event, ui ) {
		    	//#map-country is the id of hiddenInput.
				//alert(ui.item.id);
		        $('#map-id_map').val(ui.item.id);
		    }")],
		])->label('Введите искомую страну и выберете её из списка') ?>

		<?=Html::activeHiddenInput($modelAnswerMap, 'id_map', ['id' => 'map-id_map', 'value' => $modelAnswerMap->id_map])?>

		<div class="form-group">
	        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
	    </div>

	<?php endif; ?>



    <?php ActiveForm::end(); ?>

</div>
