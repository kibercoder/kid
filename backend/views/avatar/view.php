<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Avatar */

$this->title = $model->id_avatar;
$this->params['breadcrumbs'][] = ['label' => 'Avatars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$model->avatar_name = '/avatars/165x165/site/'.$model->avatar_name. '?get='.  time();

?>
<div class="avatar-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id_avatar], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id_avatar], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уврены что вы хотите удалить этот автар?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_avatar',
            [
                'attribute'=>'avatar_name',
                'value'=>function($model){
                    return $model->avatar_name;
                },
                'format' => ['image', [
                                        'width' => '48', 
                                        'height' => '48', 
                                        'alt' => $model->avatar_name,
                                        'title' => $model->avatar_name
                                      ]
                            ],
            ],
            [
                'attribute'=>'gender',
                'value'=>function($model){
                    return ($model->gender == 'm') ? 'Мужчина' : 'Женщина';
                },
            ],

        ],
    ]) ?>

</div>
