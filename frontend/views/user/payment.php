<?php
use yii\helpers\Url;
use frontend\assets\PaymentAsset;
PaymentAsset::register($this);
$this->title = 'Оплата';
?>

<div class="payment__about">
  <p class="payment__title">Оплата проживания в кидворке на 1 год</p>
  <div class="payment__kidwork">
    <p class="payment__text">Кидворк - виртуальный город, где можно попробовать себя в разных профессиях, поставить цель и заработать на нее в течение года.</p>
    <p class="payment__text">Проживание в Кидворке оплачивается раз в год и стоит всего 300 рублей.</p>
  </div>
</div>

<div class="payment__container">
  <p class="payment__title">Оплата подписки на 1 год</p>

  <div class="payment__step payment__step_data">
    <p class="payment__subtitle"><span>Шаг 1</span> Ваши данные</p>
    <div class="payment__row">
      <p class="payment__text">Фамилия и Имя</p>
      <input class="payment__input" type="text" placeholder="Фамилия">
      <input class="payment__input" type="text" placeholder="Имя">
    </div>
    <div class="payment__row">
      <p class="payment__text">E-mail</p>
      <input class="payment__input" type="email" placeholder="e-mail@email.ru">
    </div>
  </div>

  <div class="payment__step payment__step_way">
    <p class="payment__subtitle"><span>Шаг 2</span> Способ оплаты</p>
    <div class="payment__block">
      <input type="radio" name="payment" id="payment1">
      <label class="payment__way" for="payment1"></label>
    </div>
    <div class="payment__block">
      <input type="radio" name="payment" id="payment2">
      <label class="payment__way" for="payment2"></label>
    </div>
    <div class="payment__block">
      <input type="radio" name="payment" id="payment3">
      <label class="payment__way" for="payment3"></label>
    </div>
    <a class="payment__button" href="javascript:void(0)">Оплатить</a>
    <p class="payment__privacy">Оформляя подписку, вы соглашаетесь с условиями <a href="javascript:void(0)">публичной оферты</a> и <a href="javascript:void(0)">политикой конфиденциальности</a>.</p>
  </div>

</div>

  <div class="payment__card">
    <p class="payment__info">Оплата подписки на 1 год</p>
    <p class="payment__info">Заказ №3425</p>
    <p class="payment__info">Сумма к оплате 300 рублей</p>
    <form class="payment__form">
      <p class="payment__title">Введите данные карты для оплаты</p>
      <p class="payment__caption">Номер карты</p>
      <input class="payment__input payment__input_card" type="" placeholder="0000 0000 0000 0000">
      <p class="payment__caption">Имя владельца</p>
      <input class="payment__input payment__input_name" type="" placeholder="IVAN IVANOV">
      <p class="payment__caption">Действует до</p>
      <input class="payment__input payment__input_date" type="" placeholder="ММ / ГГ">
      <div class="payment__cvv">
        <p class="payment__caption">Код CVV</p>
        <input class="payment__input  payment__input_cvv" type="" placeholder="CVV">
        <span>Последние 3 цифры с обратной стороны карты</span>
      </div>
      <button class="payment__button" type="submit">Оплатить</button>
    </form>
  </div>

  <div class="payment__success">
    <div class="payment__notification">
      <p class="payment__text">Оплата прошла успешно.</p>
      <p class="payment__text">Спасибо!</p>
    </div>
  </div>

  <div class="payment__error">
    <div class="payment__notification">
      <p class="payment__text">Произошла ошибка.</p>
      <p class="payment__text">Попробуйте еще раз.</p>
    </div>
  </div>