<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

use common\models\Tournament;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TournamentQuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Вопросы и ответы для турниров';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tournament-question-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать вопрос', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',

            [
                'attribute' => 'question',
                'value' => function($dataProvider) {
                    return mb_substr($dataProvider->question, 0, 100);
                },
            ],

            [
                'attribute' => 'type',
                'value' => function($dataProvider) {
                    if ($dataProvider->type == 1) return 'Ответы в виде текста';
                    if ($dataProvider->type == 2) return 'Ответы в виде фотографий';
                    if ($dataProvider->type == 3) return 'Ответ в виде карты';
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
