<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;

use yii\bootstrap\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\TournamentQuestion */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs('

	function parseGetParams() {

	   var $_GET = {};
	   var __GET = window.location.search.substring(1).split("&");
	   for(var i=0; i<__GET.length; i++) {
	      var getVar = __GET[i].split("=");
	      $_GET[getVar[0]] = typeof(getVar[1])=="undefined" ? "" : getVar[1];
	   }
	   return $_GET;
	}

	var GETArr = parseGetParams();

	$(function(){

		$("#tournamentquestion-type").change(function(){
				
			answerType = parseInt($("#tournamentquestion-type :selected").val());

			typeAge = $("#tournamentquestion-type_age").val();

			question = $("#tournamentquestion-question").val();

			var url_location = window.location.protocol+"//"+window.location.host+window.location.pathname;

			url_location+= "?question="+question+"&type_age="+typeAge+"&id="+GETArr.id;

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

?>

<div class="tournament-question-form">

    <?php $form = ActiveForm::begin([
    	'options' => ['enctype'=>'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'question')->textInput([
    		'value' => (!empty($get['question'])) ? $get['question'] : $model->question,
    ])->label('Введите вопрос') ?>

	<?php

		$type_answer = [
    		1 => 'В виде текстовых сообщений', 
    		2 => 'В виде картинок', 
    		3 => 'В виде карты'
	    ];

	    if (!empty($get['type-answer']) && isset($type_answer[$get['type-answer']])) {
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


	<?php if ($model->type == 1) : ?>

		<?php

			echo $form->field(
		        $modelAnswerString, 'photo',
		        []
		    )->fileInput()->label('Фото для подсказки');

			if (preg_match('/\.(?:jp(?:e?g|e|2)|gif|png)$/i', $modelAnswerString->photo)) {

				$src = '/img/tournament/answer_string/'.$modelAnswerString->photo. '?get='.  time();
				echo "<img src='{$src}' width='80' />";

				echo $form->field($model, 'remove_photo', [])->checkbox()->label('Удалить фотографию?');
			} else {
				echo $form->field($model, 'remove_photo', [])->hiddenInput(['value' => 0])->label(false);
			}

	    ?>


		<?= $form->field($modelAnswerString, 'answer1')->textInput([])->label('Вариант ответа 1') ?>
		<?= $form->field($modelAnswerString, 'answer2')->textInput([])->label('Вариант ответа 2') ?>
		<?= $form->field($modelAnswerString, 'answer3')->textInput([])->label('Вариант ответа 3') ?>
		<?= $form->field($modelAnswerString, 'answer4')->textInput([])->label('Вариант ответа 4') ?>

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

	<?php if ($model->type == 2) : ?>
		
		<?php

			for($i=1; $i<=8; $i++) {

				$field = "answerPhoto".$i;

				echo $form->field(
			        $modelAnswerPhoto, $field,
			        []
			    )->fileInput()->label();

				if (preg_match('/\.(?:jp(?:e?g|e|2)|gif|png)$/i', $modelAnswerPhoto->$field)) {
					$src = '/img/tournament/answer/'.$modelAnswerPhoto->$field. '?get='.  time();
					echo "<img src='{$src}' width='80' />";
				}

			}

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

	<?php if ($model->type == 3) : ?>
		
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

		<?= $form->field($modelAnswerMap, 'id_map')->hiddenInput(['id' => 'map-id_map', 'value' => $modelAnswerMap->id_map])->label(false)?>


		<div class="form-group">
	        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
	    </div>

	<?php endif; ?>



    <?php ActiveForm::end(); ?>

</div>
