<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

//Подключаем стили для шаблона index
use frontend\assets\MissionAsset;
MissionAsset::register($this);
$user = $this->params['user'];
$this->title = 'Миссия - '.$user->username;

?>

  <div class="mission">

    <div class="mission__description">
      <p class="mission__title">Миссия</p>
      <p class="mission__text">Собери карточки с изображением работников 15 разных профессий и получи супербонус - 100 кидкоинов!</p>
      <p class="mission__text">Карточку профессии можно получить, пройдя хотя бы 1 игру на уровне "тяжелый" в соответствующей должности. После получения карточки, следующую карточку в данной специальности можно добыть после 50 игр на тяжелом уровне или 20 на хардкорном.</p>
      <p class="mission__text">Ты можешь обменивать ненужные карточки на нужные, общаясь с игроками и договариваясь с ними.</p>
      <p class="mission__text">На выполнение миссии у тебя есть 6 месяцев.</p>
      <a href="javascript:void(0)" class="mission__back"></a>
    </div>

    <p class="mission__timer">Осталось времени на выполнение миссии: <span>2 месяца 4 дня 22 часа</span></p>

  </div>