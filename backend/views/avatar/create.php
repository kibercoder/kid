<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Avatar */

$this->title = 'Создать Аватар';
$this->params['breadcrumbs'][] = ['label' => 'Аватары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="avatar-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('create_form', [
        'model' => $model,
    ]) ?>

</div>
