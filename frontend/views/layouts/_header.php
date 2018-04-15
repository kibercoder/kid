<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\User;
$user = $this->params['user'];
 ?>
<header class="header header_main" id="header">
  <div class="wrapper">
    <div class="header__logo">
      <a class="header__logo-link" href="javascript:void(0)"></a>
    </div>
    <div class="header__panel">
      <div class="level-wrap">
        <div class="avatar <?=$user->party ?>">
        <?php 
              echo Html::img(
                      common\models\User::getAvatar($user->id), 
                      ['alt' => $user->username]
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
      <a class="header__name" href="javascript:void(0)"><?=$user->username?></a>
      <p class="header__status">Сегодня я ем мед...</p>
      <input class="header__status-input" type="text" placeholder="Введи статус...">
      <?php

        echo Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton(
                            'Выйти',
                            ['class' => 'header__logout']
                        )
                        . Html::endForm();

      ?>
    </div>   
  </div>
</header>