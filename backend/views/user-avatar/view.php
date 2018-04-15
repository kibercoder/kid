<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\UserAvatar */

$this->title = $model->id_a;
$this->params['breadcrumbs'][] = ['label' => 'User Avatars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-avatar-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_a' => $model->id_a, 'id_u' => $model->id_u], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_a' => $model->id_a, 'id_u' => $model->id_u], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_a',
            'id_u',
        ],
    ]) ?>

</div>
