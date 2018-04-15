<?php

use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */

//Подключаем стили для шаблона index
use frontend\assets\FriendsAsset;
FriendsAsset::register($this);

$this->title = 'Друзья - '.$user->username;
//echo '<pre>'.print_r($incoming, true).'</pre>';
//echo '<pre>'.print_r($outgoing, true).'</pre>';
//die();
?>

<?php //Для того что б нам посчитать кол-во пользователей онлайн и потом еще раз не запускать цикл для их поиска и показа используем буферизацию вывода, где сохраняем htmlдля списка а количество выводим в нужном месте
ob_start() ?>
<?php $countOnlineFriends = 0; ?> 
<?php $jsFriends = []; ?> 
<?php foreach($friends as $item){ ?>
  <?php if($item->to_user_id == \Yii::$app->user->identity->id) $friend = $item->from ?>
  <?php if($item->from_user_id == \Yii::$app->user->identity->id) $friend = $item->to ?>
  <?php 
  if(!is_object($friend) || !$friend->online){
    continue; 
  }else{
    $countOnlineFriends++;
  }  
  ?>
  <?php $onlineClass = (! $friend->online) ? '' : ' friend__online';  ?>
  <div class="friends__item<?= $onlineClass; ?>" data-userId="<?= $friend->id; ?>">
    <div class="level-wrap">
      <div class="avatar <?=  $friend->party; ?>">
      <?php 
        echo Html::img(
                common\models\User::getAvatar( $friend->id), 
                ['alt' =>  $friend->username]
        );
        ?>
      </div>
      <div class="level level_medium">
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
    <div class="friends__info">
      <a class="friends__nickname" href="javascript:void(0)"><?=  $friend->username ?></a>
      <p class="friends__name"><?=  $friend->first_name.' '. $friend->last_name ?></p>
      <a class="friends__message" href="javascript:void(0)" data-userId="<?= $friend->id; ?>">Написать сообщение</a>
    </div>
    <button class="friends__delete" type="button" data-userId="<?= $friend->id; ?>">Удалить</button>           
  </div>       
<?php } ?>
<?php 
//сохраняем результат в переменную что б потом показать во вкладке онлайн
$friendsOnlineHtml = ob_get_contents(); 
ob_end_clean();
?>


<div class="friends">
<?php if($incomingCount || $outgoingCount){ ?>
  <div class="friends__header">
    <p class="friends__title">Заявки в друзья</p>
    <div class="friends__apps">
      <a class="friends__app" href="<?= Url::to(['user/friends-apps', '#' => 'incoming']); ?>">Входящие <span id="countIncoming"><?= $incomingCount ?></span></a>
      <a class="friends__app" href="<?= Url::to(['user/friends-apps', '#' => 'outcoming']); ?>">Исходящие <span id="countOutgoing"><?= $outgoingCount ?></span></a>
    </div>
  </div>
<?php } ?>

  <div class="friends__container">

    <div class="friends__counter">
      <button class="friends__button friends__button_all active" type="button">Все друзья <span id="countFriends"><?= count($friends) ?></span></button>
      <button class="friends__button friends__button_online" type="button">Друзья онлайн <span id="countOnlineFriends"><?= $countOnlineFriends ?></span></button>
    </div>
    <form class="friends__search">
      <input class="friends__input" type="text" placeholder="Введи имя друга">
      <button class="friends__search-btn" type="submit"></button>
      <button class="friends__filter-btn" type="button">Расширенный поиск</button>
      <div class="friends__filter">
        <p class="friends__filter-name">Город</p>
        <select class="friends__filter-city">
          <option>Москва</option>
          <option>Санкт-Петербург</option>
          <option>Екатеринбург</option>
          <option>Лондон</option>
          <option>Нью-Йорк</option>
        </select>
        <p class="friends__filter-name">Возраст</p>
        <div class="friends__filter-age">
          <select>
            <option>От</option>
            <option>от 10</option>
            <option>от 11</option>
            <option>от 12</option>
            <option>от 13</option>
            <option>от 14</option>
          </select>
          <select>
            <option>До</option>
            <option>до 10</option>
            <option>до 11</option>
            <option>до 12</option>
            <option>до 13</option>
            <option>до 14</option>
          </select>
        </div>
        <p class="friends__filter-name">Пол</p>
        <div class="radio-wrap">
          <input type="radio" name="group1" id="male"/><label for="male">Мужской</label>
        </div>
        <div class="radio-wrap">
          <input type="radio" name="group1" id="female"/><label for="female">Женский</label>
        </div>
        <div class="radio-wrap">
          <input type="radio" name="group1" id="any"/><label for="any">Любой</label>
        </div>
      </div>
    </form>

    <div class="friends__tab friends__tab_all active">

     <?php foreach($friends as $item){ ?>
        <?php if($item->to_user_id == \Yii::$app->user->identity->id) $friend = $item->from ?>
        <?php if($item->from_user_id == \Yii::$app->user->identity->id) $friend = $item->to ?>
        <?php if(!is_object($friend)) continue; ?>
        <?php $onlineClass = (! $friend->online) ? '' : ' friend__online';  ?>
        <div class="friends__item<?= $onlineClass; ?>" data-userId="<?= $item->from->id; ?>">
          <div class="level-wrap">
            <div class="avatar <?=  $friend->party; ?>">
            <?php 
              echo Html::img(
                      common\models\User::getAvatar( $friend->id), 
                      ['alt' =>  $friend->username]
              );
             ?>
            </div>
            <div class="level level_medium">
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
          <div class="friends__info">
            <a class="friends__nickname" href="javascript:void(0)"><?=  $friend->username ?></a>
            <p class="friends__name"><?=  $friend->first_name.' '. $friend->last_name ?></p>
            <a class="friends__message" href="javascript:void(0)">Написать сообщение</a>
          </div>
          <button class="friends__delete" type="button" data-userId="<?= $item->from->id; ?>">Удалить</button>  
        </div>      
      <?php } ?>

    </div>

    <div class="friends__tab friends__tab_online">
    <?=  $friendsOnlineHtml ?>

    </div>

  </div>

</div>
