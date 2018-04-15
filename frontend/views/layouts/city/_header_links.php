<?php
use yii\helpers\Url;
?>

<ul class="header__links">
      <li class="header__link"><a href="<?= Url::to(['site/index']); ?>">Карта</a></li>
      <li class="header__link"><a href="javascript:void(0)">Вакансии</a></li>
      <li class="header__link"><a href="javascript:void(0)">Турниры</a></li>
      <li class="header__link"><a href="javascript:void(0)">Топ-100</a></li>
      <li class="header__link"><a href="<?= Url::to(['user']); ?>">Мой дом</a></li>
</ul>