<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\User;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>


<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<?=$this->render('_head.php')?>
<body>
<?php $this->beginBody() ?>

<?=$this->render('_header.php')?>

<div class="wrapper wrapper_main">
    <?= Alert::widget() ?>

    <?=$this->render('_left_side_menu.php')?>
      
    <?= $content ?>
</div>

<?=$this->render('_modal_repost.php')?>

<a class="up-button" href="#header"></a>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
