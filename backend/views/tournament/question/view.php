<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use common\models\Tournament;

/* @var $this yii\web\View */
/* @var $model common\models\TournamentQuestion */

$this->title = $model->question;
$this->params['breadcrumbs'][] = ['label' => 'Вопросы и ответы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tournament-question-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотели бы удалить этот вопрос? Вместе с ним будут удалены все даные которые связаны с этим вопросом, кроме самого турнира!',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',

            'question',
            
            [
                'attribute' => 'type',
                'value' => function($model) {
                    if ($model->type == 1) return 'Ответы в виде текста';
                    if ($model->type == 2) return 'Ответы в виде фотографий';
                    if ($model->type == 3) return 'Ответ в виде карты';
                },
            ],

        ],
    ]) ?>

</div>
