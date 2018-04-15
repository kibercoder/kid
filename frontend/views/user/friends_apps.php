<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

//Подключаем стили для шаблона index
use frontend\assets\FriendsAsset;
FriendsAsset::register($this);

$this->title = 'Заявки в друзья - '.$user->username;
//echo '<pre>'.print_r($incoming, true).'</pre>';
//echo '<pre>'.print_r($outgoing, true).'</pre>';
//die();
?>
  <div class="friends">

    <div class="friends__header">
      <p class="friends__title">Заявки в друзья</p>
      <div class="friends__apps">
        <a class="friends__app friends__app_incoming" href="javascript:void(0)">Входящие <span id="countIncoming"><?= count($incoming) ?></span></a>
        <a class="friends__app friends__app_outcoming" href="javascript:void(0)">Исходящие <span id="countOutgoing"><?= count($outgoing) ?></span></a>
      </div>
    </div>

    <div class="friends__container">

      <div class="apps__tab apps__tab_incoming">
      <?php foreach($incoming as $item){ ?>
        <div class="friends__item">
          <div class="level-wrap">
            <div class="avatar <?= $item->from->party; ?>">
            <?php 
              echo Html::img(
                      common\models\User::getAvatar($item->from->id), 
                      ['alt' => $item->from->username]
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
            <a class="friends__nickname" href="javascript:void(0)"><?= $item->from->username ?></a>
            <p class="friends__name"><?= $item->from->first_name.' '.$item->from->last_name ?></p>
            <button class="apps__button accept-friend" type="button" data-userId="<?= $item->from->id; ?>" >Добавить в друзья</button>
          </div>
        </div>      
      <?php }?>
      </div>

      <div class="apps__tab apps__tab_outcoming">
      <?php foreach($outgoing as $item){ ?>
        <div class="friends__item">
          <div class="level-wrap">
            <div class="avatar <?= $item->to->party; ?>">
            <?php 
              echo Html::img(
                      common\models\User::getAvatar($item->to->id), 
                      ['alt' => $item->to->username]
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
            <a class="friends__nickname" href="javascript:void(0)"><?= $item->to->username ?></a>
            <p class="friends__name"><?= $item->to->first_name.' '.$item->to->last_name ?></p>
            <button class="apps__button remove-submitted" type="button" data-userId="<?= $item->to->id; ?>">Отозвать заявку</button>
          </div>
        </div>      
      <?php }?>

      </div>

    </div>

  </div>