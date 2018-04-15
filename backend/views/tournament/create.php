<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Tournament */


$this->title = 'Создать турнир';
$this->params['breadcrumbs'][] = ['label' => 'Турниры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tournament-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_create', [
        'model' => $model
    ]) ?>

</div>
