<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserAvatarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Avatars';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-avatar-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User Avatar', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_a',
            'id_u',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
