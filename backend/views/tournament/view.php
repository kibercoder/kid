<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Tournament */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Турниры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tournament-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id_t], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id_t], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что вы хотите удалить пункт? Также будут удалены все матералы связанные с этим турниром!',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_t',
            'title',
            [
                'attribute'=>'photo',
                'value'=>function($model){

                    $modelPhoto = '../../img/tournament/img_tour/'.$model->photo. '?get='. time();

                    $photoByTour = Yii::$app->params['path_frontend'].'/img/tournament/img_tour/'.$model->photo;

                    return (
                        file_exists($photoByTour)
                        && preg_match('/\.(?:jp(?:e?g|e|2)|gif|png)$/i', $model->photo)
                        ) ? $modelPhoto : "../../img/404-1.png";
                },

                'format' => ['image', [
                                        'width' => '68',
                                        'height' => '68',
                                        'alt' => $model->photo,
                                        'title' => $model->photo
                                      ]
                            ],
            ],

            [
                'attribute'=>'type',
                'value'=>function($model){
                    return ($model->type == 'individual') ? 'Индивидуальный' : 'Командный';
                },
            ],

            'cost',
            'fund',
            'first_place',
            'second_place',
            'third_place',

            [
                'attribute'=>'date_begin',
                'value'=>function($model){
                    return date("d-m-Y H:i", $model->date_begin);
                },

            ],

            [
            'attribute'=>'type_age',
                'value'=>function($model){

                    if ($model->type_age == 1) return "6-8 лет";
                    if ($model->type_age == 2) return "9-12 лет";
                    if ($model->type_age == 3) return "13-15 лет";
                },

            ],

            'max_member',
        ],
    ]) ?>

</div>
