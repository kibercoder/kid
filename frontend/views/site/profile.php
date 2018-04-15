<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

//Подключаем стили для шаблона index
use frontend\assets\ProfileAsset;
ProfileAsset::register($this);

$this->title = 'Дом - '.\Yii::$app->user->identity->username;

?>

  <div class="mypanel">
    
    <div class="myuser">
      <span class="user__online active">Online</span>
      <div class="level-wrap">
        <div class="avatar red">
          <?php 
              echo Html::img(
                      common\models\User::getAvatar(\Yii::$app->user->identity->id), 
                      ['alt' => \Yii::$app->user->identity->username]
              );
          ?>
        </div>
        <div class="level">
          <span class="level__star"></span>
          <span class="level__star"></span>
          <span class="level__star"></span>
          <span class="level__star"></span>
          <span class="level__star"></span>
          <span class="level__star"></span>
          <span class="level__star"></span>
          <span class="level__star"></span>
          <span class="level__star"></span>
          <span class="level__star"></span>
          <span class="level__star"></span>
          <span class="level__star"></span>
          <span class="level__star"></span>
          <span class="level__star"></span>
          <span class="level__star"></span>
        </div>
      </div>
      <button class="user__edit" type="button">Редактировать</button>
      <div class="user__gifts">
        <img src="../img/profile/loc4.png" alt="">
      </div>
      <button class="user__gift-button"></button>
    </div>

    <div class="aim">
      <div class="aim__row">
        <a class="aim__left aim__link" href="javascript:void(0)">Цель:</a>
        <p class="aim__right">Велосипед BMW</p>
      </div>
      <div class="aim__row">
        <p class="aim__left">До цели:</p>
        <p class="aim__right">5000 кидкоинов</p>
      </div>
      <div class="aim__row">
        <p class="aim__left">Финиш:</p>
        <p class="aim__right">25.12.2018</p>
      </div>
      <button class="aim__choose">Выбери цель</button>
    </div>

    <div class="friends">
    	<a class="friends__title"  href="javascript:void(0)">Друзья онлайн <span>3</span></a>
      <a class="friends__item" href="javascript:void(0)">
        <div class="level-wrap">
          <div class="avatar red">
            <img src="../img/profile/user.jpg" alt="">
          </div>
          <div class="level level_small">
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
          </div>
        </div>
        <p class="friends__name">Медвежонок</p>
      </a>
      <a class="friends__item" href="javascript:void(0)">
        <div class="level-wrap">
          <div class="avatar blue">
            <img src="../img/profile/user.jpg" alt="">
          </div>
          <div class="level level_small">
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
          </div>
        </div>
        <p class="friends__name">Медвежонок</p>
      </a>
      <a class="friends__item" href="javascript:void(0)">
        <div class="level-wrap">
          <div class="avatar green">
            <img src="../img/profile/user.jpg" alt="">
          </div>
          <div class="level level_small">
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
          </div>
        </div>
        <p class="friends__name">Медвежонок</p>
      </a>
    </div>

    <div class="location">
      <p class="location__title">Локации <span>15</span></p>
      <ul class="location__list">
        <li class="location__item"><a href="javascript:void(0)">Киностудия</a></li>
        <li class="location__item"><a href="javascript:void(0)">Госдума</a></li>
        <li class="location__item"><a href="javascript:void(0)">Редакция газеты</a></li>
        <li class="location__item"><a href="javascript:void(0)">Домик стилиста</a></li>
        <li class="location__item"><a href="javascript:void(0)">Полиция</a></li>
        <li class="location__item"><a href="javascript:void(0)">Больница</a></li>
        <li class="location__item"><a href="javascript:void(0)">Студия дизайна</a></li>
        <li class="location__item"><a href="javascript:void(0)">Стройка</a></li>
        <li class="location__item"><a href="javascript:void(0)">Бизнес-центр</a></li>
        <li class="location__item"><a href="javascript:void(0)">Радиостанция</a></li>
        <li class="location__item"><a href="javascript:void(0)">Академия</a></li>
        <li class="location__item"><a href="javascript:void(0)">Банк</a></li>
        <li class="location__item"><a href="javascript:void(0)">Магазин</a></li>
        <li class="location__item"><a href="javascript:void(0)">Киоск</a></li>
        <li class="location__item"><a href="javascript:void(0)">Фонтан</a></li>
      </ul>
    </div>

  </div>

<?php
  function dateString($date = false)
  {

    if (!is_numeric($date)) return false;

    $aMonth = array(1 => 'января',2 => 'февраля',3 => 'марта',4 => 'апреля',5 => 'мая',6 => 'июня',7 => 'июля',8 => 'августа',9 => 'сентября',10 => 'октября',11 => 'ноября',12 => 'декабря');

    $day = date('j', $date);
    $month = date('n', $date);
    $year = date('Y', $date);
        
    return "Житель Квидворка с {$day}&nbsp;{$aMonth[$month]}&nbsp;{$year} года";

  }

  function getAge($date) {

    if (!is_numeric($date)) return false;

    $m = date('j', $date);
    $d = date('n', $date);
    $y = date('Y', $date);

    if($m > date('n') || $m == date('n') && $d > date('j'))
      return (date('Y') - $y - 1);
    else
      return (date('Y') - $y);
  }

?>


  <div class="wall">
    
    <div class="wall__info">
      <p class="wall__name">
        <?=\Yii::$app->user->identity->first_name?>&nbsp;<?=\Yii::$app->user->identity->last_name?>
      </p>
      <p class="wall__about"><?=dateString(\Yii::$app->user->identity->created_at);?></p>
      <p class="wall__age">
        Возраст: 
        <span><?=getAge(\Yii::$app->user->identity->birthdate)?> лет</span>
      </p>
      <p class="wall__profession">Лучшая профессия: <span>Повар</span></p>
      <p class="wall__achieve">Достижения: <span>3 место в турнире "Спорт"</span></p>
      <button class="more-achieve" type="button"></button>
      <div class="wall__achieve_more">
        <p class="wall__achieve"><span>3 место в турнире "Спорт"</span></p>
        <p class="wall__achieve"><span>3 место в турнире "Спорт"</span></p>
      </div>
    </div>

    <?php

    echo \yii2mod\comments\widgets\Comment::widget([

      'model' => $user,
      'commentView' => '@app/views/site/comments/profile/index',

      'maxLevel' => 0,
      'dataProviderConfig' => [
          'sort' => [
              'attributes' => ['id'],
              'defaultOrder' => ['id' => SORT_DESC],
          ],
          'pagination' => [
              'pageSize' => 3
          ],
      ],

    
    ]); ?>


  </div>