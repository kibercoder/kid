<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TournamentQuestion */

$this->title = 'Создать вопрос';
$this->params['breadcrumbs'][] = ['label' => 'Вопросы и ответы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tournament-question-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_create', [
        'model' => $model,
	    'modelAnswerString' => $modelAnswerString,
	    'modelAnswerPhoto' => $modelAnswerPhoto,
	    'modelAnswerMap' => $modelAnswerMap,
	    'modelMap' => $modelMap,
	    'countryMap' => $countryMap,
	    'tournament' => $tournament,
	    'tournaments' => $tournaments
    ]) ?>

</div>
