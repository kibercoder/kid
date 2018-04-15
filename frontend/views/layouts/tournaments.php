<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>


<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!--meta name="viewport" content="width=device-width, initial-scale=1"-->

    <meta http-equiv="Content-Language" content="ru" />

    <?= Html::csrfMetaTags() ?>

    <title><?= Html::encode($this->title) ?></title>

    <link rel="icon" href="/favicon.ico" type="image/x-icon" />

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />

    <meta name="description" content="" />

    <meta name="keywords" content="" />

    <script type="text/javascript">
        window.onload = function() {
            if(screen.width < 600){
                $("head").append('<link rel="stylesheet" type="text/css" href="/css/touches.css" />'); 
            }
        }
    </script>

    <?php $this->head() ?>

</head>

<body id="tournament">

    <?php $this->beginBody() ?>

        <?= Alert::widget() ?>
        <?= $content ?>

    <?php $this->endBody() ?>
    
</body>
</html>
<?php $this->endPage() ?>
