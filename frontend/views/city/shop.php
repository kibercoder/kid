<?php
use yii\helpers\Url;
use frontend\assets\ShopAsset;
ShopAsset::register($this);
$this->title = 'Магазин';
?>

  <p class="shop__description">Выбери цель на год! Посмотри варианты и определись, на что ты будешь копить кидкоины целый год. Если тебе удастся за год заработать на нашем сайте нужное количество кидкоинов, то ты получишь выбранный подарок по почте. Цель можно выбрать только один раз за год и менять в течение года нельзя. Подумай хорошо и определись.</p>

<div class="shop">

  <div class="shop__item">
    <div class="shop__image">
      <img src="/img/shop1.jpg" alt="">
    </div>
    <p class="shop__name">Годовой запас конфет</p>
    <p class="shop__cost">2000 кидкоинов</p>
    <button class="shop__choose" type="button">Выбрать</button>
  </div>

  <div class="shop__item">
    <div class="shop__image">
      <img src="/img/shop2.jpg" alt="">
    </div>
    <p class="shop__name">Смартфон iPhone X</p>
    <p class="shop__cost">8000 кидкоинов</p>
    <button class="shop__choose" type="button">Выбрать</button>
  </div>

  <div class="shop__item">
    <div class="shop__image">
      <img src="/img/shop3.jpg" alt="">
    </div>
    <p class="shop__name">Поездка на двоих в Диснейленд</p>
    <p class="shop__cost">15 000 кидкоинов</p>
    <button class="shop__choose" type="button">Выбрать</button>
  </div>

  <div class="shop__item">
    <div class="shop__image">
      <img src="/img/shop4.jpg" alt="">
    </div>
    <p class="shop__name">Велосипед BMW</p>
    <p class="shop__cost">10 000 кидкоинов</p>
    <button class="shop__choose" type="button">Выбрать</button>
  </div>

  <div class="shop__item">
    <div class="shop__image">
      <img src="/img/shop5.jpg" alt="">
    </div>
    <p class="shop__name">Плюшевый мишка</p>
    <p class="shop__cost">1500 кидкоинов</p>
    <button class="shop__choose" type="button">Выбрать</button>
  </div>

  <div class="shop__item">
    <div class="shop__image">
      <img src="/img/shop6.jpg" alt="">
    </div>
    <p class="shop__name">Аренда жилья в Кидворк на год</p>
    <p class="shop__cost">100 кидкоинов</p>
    <button class="shop__choose" type="button">Выбрать</button>
  </div>

</div>
