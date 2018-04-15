<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TournamentQuestion */

$this->title = 'Обновить вопрос: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Вопросы и ответы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="tournament-question-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_update', [
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
