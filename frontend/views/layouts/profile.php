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

$user = $this->params['user'];
$owner = $this->params['owner'];
$gifts  = $this->params['gifts'];

?>
<?php $this->beginPage() ?>


<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <?=$this->render('_head.php')?>
</head>

<body id="profile">
<?php $this->beginBody() ?>

<header class="header" id="header">
  <div class="wrapper">
    <div class="header__logo">
      <a class="header__logo-link" href="javascript:void(0)"></a>
    </div>
    <div class="header__panel">
      <a class="header__name" href="javascript:void(0)">
        <?=$user->username?>
      </a>
      <p class="header__status">Сегодня я ем мед...</p>
      <input class="header__status-input" type="text" placeholder="Введи статус...">

      <?php

        echo Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton(
                            'Выйти',
                            ['class' => 'header__logout']
                        )
                        . Html::endForm();

      ?>

    </div>
  </div>
</header>

<div class="wrapper wrapper_main">
    <?= Alert::widget() ?>
    <?=$this->render('_left_side_menu.php')?>
    <?= $content ?>
</div>


<section class="modal modal_repost">
  <div class="modal__wrap">
    <p class="modal__title">Добавь свой комментарий:</p>
    <form class="wall__form">
      <textarea class="wall__input" type="text" placeholder="Новая запись"></textarea>
      <button class="wall__affix" type="button"></button>
    </form>
    <button class="modal__repost" type="button">Ответить</button>
  </div>
</section>
<?php if(!$owner){ ?>
<div class="modal modal_message">
  <div class="modal__wrap">
    <p class="modal__title">Напиши сообщение:</p>
    <form class="wall__form" id="message_form">
      <textarea class="wall__input" type="text" placeholder="Твое сообщение..." id="message_txt"></textarea>
      <button class="wall__affix" type="button"></button>
      <input type="file" id="message_file"  accept="image/jpeg,image/png,image/gif,text/plain" />
    </form>
    <button class="modal__repost" type="button" id="send_message" data-userId="<?= $user->id; ?>">Отправить</button>
  </div>
</div>

<div class="modal modal_gift">
  <div class="modal__wrap">
    <?php foreach($gifts as $gift){ ?>
    <div class="gift">
      <img class="gift__image" src="<?= $gift->url ?>" alt="">
      <p class="gift__cost"><?= $gift->price ?> кидкоина</p>
      <button class="gift__button" type="button"  data-userId="<?= $user->id; ?>" data-giftId="<?= $gift->id; ?>">Подарить</button>
    </div>
    <?php } ?>
    <button class="modal__close" type="button"></button>

  </div>
</div>
<?php } ?>
<a class="up-button" href="#header"></a>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
