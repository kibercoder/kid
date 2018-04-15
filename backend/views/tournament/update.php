<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Tournament */

$this->title = 'Обновление турнира: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Турниры', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id_t]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="tournament-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_update', [
        'model' => $model,
    ]) ?>

</div>
