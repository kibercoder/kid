<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;

/* @var $this yii\web\View */

//Подключаем стили для шаблона index
use frontend\assets\DialogsAsset;
DialogsAsset::register($this);
$user = $this->params['user'];
$this->title = 'Диалоги - '.$user->username;
?>

<div class="dialog-list">

  <form class="dialog-list__search">
    <input class="dialog-list__input" type="text" placeholder="Поиск"> 
    <button  class="dialog-list__search-btn"type="button"></button>
  </form>
  <?php if(count($dialogList)){ ?>
    <?php $checkDublicate = []; ?>
    <?php foreach($dialogList as $item){ ?> 
      <?php if($item->to_user_id == \Yii::$app->user->identity->id) $opponent = $item->from; ?>
      <?php if($item->from_user_id == \Yii::$app->user->identity->id) $opponent = $item->to; ?>
      <?php 
      if(!array_key_exists( $opponent->username , $checkDublicate)){
        $checkDublicate[$opponent->username] = '';
      }else{
        continue;
      }
      ?>
      <?php $onlineClass = ($opponent->online) ? ' online' : '' ;  ?>
      <a class="dialog-list__item<?= $onlineClass; ?>" href="<?= Url::to(['user/dialog/'.$opponent->id]); ?>">
        <div class="level-wrap">
          <div class="avatar <?= $opponent->party; ?>">
          <?php 
                echo Html::img(
                        common\models\User::getAvatar( $opponent->id), 
                        ['alt' =>  $opponent->username]
                );
          ?>
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
        <div class="gialog-list__info users-last">
          <p class="dialog-list__name"><?= $opponent->username ?></p>
          <?php if($item->from_user_id == \Yii::$app->user->identity->id){ ?>
          <div class="users-message">
            <div class="level-wrap level_comment">
              <div class="avatar <?=  $user->party; ?>">
              <?php 
                echo Html::img(
                        common\models\User::getAvatar( $user->id), 
                        ['alt' =>  $user->username]
                );
          ?>
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
            <p class="dialog-list__description"><?= $item->text ?></p>
          </div>
          <?php }else{ ?>
            <p class="dialog-list__description"><?= $item->text ?></p>
          <?php } ?>
        </div>
        <p class="dialog-list__time"><?= $item->created ?></p>
        <button class="dialog-list__delete" type="button"></button>
      </a>
    <?php } ?>
  <?php } ?>
<!--
  <div class="dialog-list__item">
    <div class="level-wrap">
      <div class="avatar green">
        <img src="img/user2.jpg" alt="">
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
    <div class="gialog-list__info">
      <p class="dialog-list__name">Грейс Келли</p>
      <p class="dialog-list__description">Тогда и я хочу пойти на выборы завтра</p>
      <p class="dialog-list__time">21:05</p>
    </div>
    <button class="dialog-list__delete" type="button"></button>
  </div>

  <div class="dialog-list__item">
    <div class="level-wrap">
      <div class="avatar blue">
        <img src="img/user2.jpg" alt="">
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
    <div class="gialog-list__info">
      <p class="dialog-list__name">Грейс Келли</p>
      <p class="dialog-list__description">Lorem Ipsum не только успешно пережил без заметных изменений пять веков, но и перешагнул в электронный дизайн.</p>
      <p class="dialog-list__time">вчера</p>
    </div>
    <button class="dialog-list__delete" type="button"></button>
  </div>

  <div class="dialog-list__item online">
    <div class="level-wrap">
      <div class="avatar blue">
        <img src="img/user2.jpg" alt="">
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
    <div class="gialog-list__info">
      <p class="dialog-list__name">Грейс Келли</p>
      <p class="dialog-list__description">Тогда и я хочу пойти на выборы завтра</p>
      <p class="dialog-list__time">10 фев</p>
    </div>
    <button class="dialog-list__delete" type="button"></button>
  </div>
</div>
-->