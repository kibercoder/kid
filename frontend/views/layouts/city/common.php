<?php

/* @var $this \yii\web\View */
/* @var $content string */

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\Alert;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="format-detection" content="telephone=no">
  <?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<header class="header header_<?= Yii::$app->controller->action->id ?>" id="header">
  <div class="wrapper">

    <div class="header__logo">
      <a class="header__logo-link" href="javascript:void(0)"></a>
    </div>
    <?=$this->render('_header_links.php')?>

    <?php

    echo Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Выйти',
                    ['class' => 'header__logout']
                )
                . Html::endForm();

    ?>
  </div>
</header>

<div class="<?= Yii::$app->controller->action->id ?>">
  <div class="wrapper">
    <?= $content ?>
  </div>
</div>

<?php if(Yii::$app->controller->action->id  == 'academy'){ ?>
<div class="modal modal_academy">
  <div class="modal__wrap">

    <div class="test__start">
      <p class="test__description">Если все понятно, то пройди тест. Чтобы устроиться на должность журналиста, необходимо ответить правильно на все вопросы.</p>
      <button class="test__button test__button_start" type="button">Пройти тест</button>
      <button class="test__button" type="button">Смотреть ролик еще раз</button>
    </div>

    <div class="test__item">
      <p class="test__question">С чего должна начинаться статья?</p>
      <div class="test__answer">
        <span class="test__letter">А</span>
        <button class="test__button" type="button">Описание события, его дата и место</button>
      </div>
      <div class="test__answer">
        <span class="test__letter">Б</span>
        <button class="test__button" type="button">Интервью с участниками события</button>
      </div>
      <div class="test__answer">
        <span class="test__letter">В</span>
        <button class="test__button" type="button">Интервью со свидетелями события</button>
      </div>
      <div class="test__answer">
        <span class="test__letter">Г</span>
        <button class="test__button" type="button">Мнение автора статьи</button>
      </div>
    </div>

    <div class="test__error">
      <p class="test__description">К сожалению, ответ неверный.</p>
      <p class="test__description">Тест не пройден. Попробуй еще раз.</p>
      <button class="test__button">Смотреть ролик еще раз</button>
    </div>

    <div class="test__success">
      <p class="test__description">Ты отлично справился!</p>
      <p class="test__description">Можешь устроиться на должность журналиста в редакции.</p>
    </div>

  <button class="modal__close"></button>
  </div>
</div>
<?php } ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>