<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

//Подключаем стили для шаблона index
use frontend\assets\WorksAsset;
WorksAsset::register($this);
$user = $this->params['user'];
$this->title = 'Работа - '.$user->username;

?>

   <div class="professions">

    <p class="professions__title">Профессии и мой уровень</p>
    <table class="professions__table">
      <tr class="professions__row">
        <td>Профессия</td>
        <td>Легкий <br>уровень</td>
        <td>Средний <br>уровень</td>
        <td>Тяжелый <br>уровень</td>
        <td>Хардкорный <br>уровень</td>
      </tr>
      <tr class="professions__row">
        <td>Повар</td>
        <td></td>
        <td>10 игр</td>
        <td></td>
        <td></td>
      </tr>
      <tr class="professions__row">
        <td>Журналист</td>
        <td>20 игр</td>
        <td></td>
        <td></td>
        <td>2 игры</td>
      </tr>
      <tr class="professions__row">
        <td>Продюссер</td>
        <td></td>
        <td>10 игр</td>
        <td></td>
        <td></td>
      </tr>
      <tr class="professions__row">
        <td>Стилист</td>
        <td></td>
        <td></td>
        <td>1 игра</td>
        <td></td>
      </tr>
      <tr class="professions__row">
        <td>Инженер <span class="professions__new">New</span></td>
        <td></td>
        <td>20 игр</td>
        <td></td>
        <td></td>
      </tr>
      <tr class="professions__row">
        <td>Программист</td>
        <td></td>
        <td></td>
        <td></td>
        <td>10 игр</td>
      </tr>
      <tr class="professions__row">
        <td>Дизайнер</td>
        <td></td>
        <td>5 игр</td>
        <td></td>
        <td></td>
      </tr>
      <tr class="professions__row">
        <td>Банкир</td>
        <td></td>
        <td></td>
        <td></td>
        <td>2 игры</td>
      </tr>
      <tr class="professions__row">
        <td>Доктор</td>
        <td></td>
        <td></td>
        <td>3 игры</td>
        <td></td>
      </tr>
      <tr class="professions__row">
        <td>Учитель</td>
        <td>105 игр</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr class="professions__row">
        <td>Диджей <span class="professions__new">New</span></td>
        <td></td>
        <td></td>
        <td>1 игра</td>
        <td></td>
      </tr>
      <tr class="professions__row">
        <td>Предприниматель</td>
        <td>5 игр</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr class="professions__row">
        <td>Дизайнер</td>
        <td></td>
        <td>3 игры</td>
        <td></td>
        <td></td>
      </tr>
      <tr class="professions__row">
        <td>Полицейский <span class="professions__new">New</span></td>
        <td>10 игр</td>
        <td></td>
        <td></td>
        <td>1 игра</td>
      </tr>
    </table>

  </div>