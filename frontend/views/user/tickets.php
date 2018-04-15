<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

//Подключаем стили для шаблона index
use frontend\assets\TicketsAsset;
TicketsAsset::register($this);
$user = $this->params['user'];
$this->title = 'Билеты - '.$user->username;

?>
  <div class="tickets">

    <p class="tickets__title">Мои билеты на турниры</p>
    <table class="tickets__table">
      <tr class="tickets__row">
        <td>Начало</td>
        <td>Цена</td>
        <td>Тип</td>
        <td>Название</td>
      </tr>
      <tr class="tickets__row">
        <td>5 фев 21:15</td>
        <td>2 КК</td>
        <td>Инд</td>
        <td>Вокруг света</td>
      </tr>
      <tr class="tickets__row">
        <td>12 фев 11:25</td>
        <td>1 КК</td>
        <td>Ком</td>
        <td>В мире животных</td>
      </tr>
      <tr class="tickets__row">
        <td>5 фев 21:15</td>
        <td>2 КК</td>
        <td>Инд</td>
        <td>Вокруг света</td>
      </tr>
      <tr class="tickets__row">
        <td>12 фев 11:25</td>
        <td>1 КК</td>
        <td>Ком</td>
        <td>Очень длинное название турнира</td>
      </tr>

    </table>

  </div>