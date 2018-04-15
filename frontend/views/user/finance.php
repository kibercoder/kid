<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

//Подключаем стили для шаблона index
use frontend\assets\FinanceAsset;
FinanceAsset::register($this);
$user = $this->params['user'];
$this->title = 'Финансы - '.$user->username;

?>

   <div class="finance">

    <div class="finance__item">
      <p class="finance__title">Количество средств<br> на счете</p>
      <a class="finance__info finance__account" href="javascript:void(0)">14 000 кидкоинов</a>
    </div>
    <div class="finance__item">
      <p class="finance__title">Заработано<br> за январь</p>
      <a class="finance__info finance__month" href="javascript:void(0)">14 000 кидкоинов</a>
    </div>
    <div class="finance__item finance__item_aim">
      <p class="finance__title">Цель: <a class="finance__info finance__aim" href="javascript:void(0)">Велосипед BMW</a></p>
      <p class="finance__title">Цена: <a class="finance__info finance__cost" href="javascript:void(0)">20 000 кидкоинов</a></p>
      <p class="finance__title">Финиш: <a class="finance__info finance__finish" href="javascript:void(0)">30 декабря 2018</a></p>
    </div>
    <div class="finance__item">
      <p class="finance__title">Жилье оплачено до:</p>
      <a class="finance__info finance__house" href="javascript:void(0)">Временное бесплатное</a>
      <a class="finance__pay" href="<?= Url::to(['user/payment']); ?>">Оплатить</a>
    </div>

  </div>