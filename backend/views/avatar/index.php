<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AvatarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Avatars';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="avatar-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Avatar', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_avatar',
            [
                'attribute' => 'avatar_name',
                'format' => 'raw',
                'value' => function($dataProvider) {
                    $src = '/avatars/165x165/site/'.$dataProvider->avatar_name. '?get='.  time();
                    return Html::img(Url::to($src), ['alt' => $src, 'width' => 48]);
                },
            ],
            [
                'attribute' => 'gender',
                'value' => function($dataProvider) {
                    return ($dataProvider->gender == 'm') ? 'Мужчина' : 'Женщина';
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
