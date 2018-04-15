<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Avatar */

$this->title = 'Обновить аватар:';
$this->params['breadcrumbs'][] = ['label' => 'Аватары', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_avatar, 'url' => ['view', 'id' => $model->id_avatar]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="avatar-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('update_form', [
        'model' => $model
    ]) ?>

</div>
