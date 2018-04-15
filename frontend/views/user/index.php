<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

//Подключаем стили для шаблона index
use frontend\assets\ProfileAsset;
ProfileAsset::register($this);
$user = $this->params['user'];
$owner = $this->params['owner'];
$userGifts = $this->params['userGifts'];
//echo '<pre>'.print_r(, true).'</pre>';;
$this->title = 'Дом - '.$user->username;

?>
  <div class="mypanel">
    
    <div class="myuser">
      <?php if(!$owner){ ?>
        <?php $userOnlineClass = ($userOnline) ? " active" : ""; ?>
        <?php $userOnlineText = ($userOnline) ? "Online" : ""; ?>
        <span class="user__online<?= $userOnlineClass; ?>"><?= $userOnlineText; ?></span>
      <?php } ?>
      <div class="level-wrap">
        <div class="avatar <?= $user->party; ?>">
          <?php 
              echo Html::img(
                      common\models\User::getAvatar($user->id), 
                      ['alt' => $user->username]
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
      <?php if($owner){ ?>
      <a class="user__edit" href="user/edit-profile">Редактировать</a>
      <?php }else{ ?>
        <?php if(!$checkAlreadyFriend){ ?>
          <a class="user__edit" href="user/add-friend" data-userId="<?= $user->id; ?>" id="add-friend">Добавить в друзья</a>
        <?php }else if(!$checkAlreadyFriend['accept']){ ?>  
          <a class="user__edit friend-submitted" href="user/remove-friend" data-userId="<?= $user->id; ?>" id="remove-friend">Заявка отправлена</a>  
        <?php }else{ ?>  
          <a class="user__edit friend-remove" href="user/remove-friend" data-userId="<?= $user->id; ?>" id="remove-friend">&#9733; Друзья</a>
        <?php } ?>
      
      <?php } ?>
      <?php if($owner){ ?>
      <div class="user__gifts">
        <img src="<?php echo (isset($userGifts[0]))? $userGifts[0]->gift->url : '' ?>" alt="" id="gift-1">
      </div>
      <?php }else{ ?>
      <button class="user__send-message" type="button"></button>
      <?php } ?>
      <?php if(!$owner){ ?>
      <button class="user__gift-button" data-userId="<?= $user->id; ?>"></button>
      <?php } ?>
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
    <?php if($owner){ ?>
      <?=$this->render('_locations.php')?>
    <?php } ?> 
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
        <?=$user->first_name?>&nbsp;<?=$user->last_name?>
      </p>
      <p class="wall__about"><?=dateString($user->created_at);?></p>
      <p class="wall__age">
        Возраст: 
        <span><?=getAge($user->birthdate)?> лет</span>
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