<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TournamentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Турниры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tournament-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать турнир', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_t',
            'title',
            [
                'attribute' => 'photo',
                'format' => 'raw',
                'value' => function($dataProvider) {
                    $src = '/img/tournament/img_tour/'.$dataProvider->photo. '?get='.  time();

                    $photoByTour = Yii::$app->params['path_frontend'].'/img/tournament/img_tour/'.$dataProvider->photo;

                    $src = (
                        file_exists($photoByTour)
                        && preg_match('/\.(?:jp(?:e?g|e|2)|gif|png)$/i', $dataProvider->photo)
                        ) ? $src : "../../img/404-1.png";

                    return Html::img(Url::to($src), ['alt' => $src, 'width' => 68]);
                },
            ],

            [
                'attribute' => 'type',
                'value' => function($dataProvider) {
                    return ($dataProvider->type == 'individual') ? 'Индивидуальный' : 'Командный';
                },
            ],

            'cost',
            //'fund',
            //'first_place',
            //'second_place',
            //'third_place',
            //'date_begin',
            //'type_age',
            //'max_member',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
