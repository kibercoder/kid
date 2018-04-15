<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserAvatar */

$this->title = 'Update User Avatar: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'User Avatars', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_a, 'url' => ['view', 'id_a' => $model->id_a, 'id_u' => $model->id_u]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-avatar-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
