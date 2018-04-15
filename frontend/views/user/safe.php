<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

//Подключаем стили для шаблона index
use frontend\assets\SafeAsset;
SafeAsset::register($this);
$user = $this->params['user'];
$this->title = 'Сейф - '.$user->username;

?>

  <div class="safe">

    <p class="safe__title">Содержимое сейфа <span class="safe__counter">2</span></p>
    <div class="safe__container">

      <div class="safe__item">
        <div class="safe__card">
          <img src="img/safe1.png" alt="">
        </div>
        <p class="safe__name">Карточка "Полицейский"</p>
      </div>
      <div class="safe__item">
        <div class="safe__card">
          <img src="img/safe1.png" alt="">
        </div>
        <p class="safe__name">Карточка "Полицейский"</p>
      </div>
      <div class="safe__item">
        <div class="safe__card">
          <img src="img/safe1.png" alt="">
        </div>
        <p class="safe__name">Карточка "Полицейский"</p>
      </div>
      <div class="safe__item">
        <div class="safe__card">
          <img src="img/safe1.png" alt="">
        </div>
        <p class="safe__name">Карточка "Полицейский"</p>
      </div>
      <div class="safe__item">
        <div class="safe__card">
          <img src="img/safe1.png" alt="">
        </div>
        <p class="safe__name">Карточка "Полицейский"</p>
      </div>
      <div class="safe__item">
        <div class="safe__card">
          <img src="img/safe1.png" alt="">
        </div>
        <p class="safe__name">Карточка "Полицейский"</p>
      </div>

    </div>

  </div>