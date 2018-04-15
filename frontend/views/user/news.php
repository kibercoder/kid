<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

//Подключаем стили для шаблона index
use frontend\assets\NewsAsset;
NewsAsset::register($this);
$user = $this->params['user'];
$this->title = 'Новости - '.$user->username;

?>

  <div class="wall wall_news">

    <form class="wall__form">
      <input class="wall__input" type="text" placeholder="Новая запись">
      <button class="wall__affix" type="button"></button>
    </form>

    <div class="post">
      <header class="post__header">
        <div class="level-wrap online">
          <div class="avatar red">
            <img src="img/user.jpg" alt="">
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
          <div class="post__info">
            <a class="post__name" href="javascript:void(0)">Медвежонок</a>
            <time class="post__time">15 янв в 21:45</time>
          </div>
      </header>
      <div class="post__content">
        <img src="img/post1.jpg" alt="">
      </div>
      <footer class="post__footer">
        <button class="like" type="button">18</button>
        <button class="comment" type="button">10</button>
        <button class="repost" type="button">18</button>
      </footer>

      <div class="post__comments-wrap">

        <div class="post__comment">
          <header class="comment__header">
            <div class="level-wrap">
              <div class="avatar red">
                <img src="img/user.jpg" alt="">
              </div>
              <div class="level level_comment">
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
            <div class="comment__info">
              <a class="comment__name" href="javascript:void(0)">Катя Иванова</a>
              <time class="comment__time">15 янв в 21:45</time>
            </div>
          </header>
          <p class="comment__text">Lorem Ipsum не только успешно пережил без заметных изменений пять веков, но и перешагнул в электронный дизайн.</p>
          <footer class="comment__footer">
            <button class="like" type="button">18</button>
            <button class="repost" type="button">Ответить</button>
          </footer>
        </div>

        <button class="comment__more" type="button">Все комментарии</button>
        <div class="comment__more-wrap">

          <div class="post__comment">
            <header class="comment__header">
              <div class="level-wrap">
                <div class="avatar red">
                  <img src="img/user.jpg" alt="">
                </div>
                <div class="level level_comment">
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
              <div class="comment__info">
                <a class="comment__name" href="javascript:void(0)">Катя Иванова</a>
                <time class="comment__time">15 янв в 21:45</time>
              </div>
            </header>
            <p class="comment-text">Lorem Ipsum не только успешно пережил без заметных изменений пять веков, но и перешагнул в электронный дизайн.</p>
            <footer class="comment__footer">
              <button class="like" type="button">18</button>
              <button class="repost" type="button">Ответить</button>
            </footer>
          </div>

        </div>

      </div>
    </div>

    <div class="post">
      <header class="post__header">
        <div class="level-wrap">
          <div class="avatar red">
            <img src="img/user.jpg" alt="">
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
          <div class="post__info">
            <a class="post__name" href="javascript:void(0)">Медвежонок</a>
            <time class="post__time">15 янв в 21:45</time>
          </div>
      </header>
      <div class="post__content">
        <p>Lorem Ipsum - это текст-"рыба", часто используемый в печати и веб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века.</p>
        <p>В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов.</p>
      </div>
      <footer class="post__footer">
        <button class="like" type="button">18</button>
        <button class="comment" type="button">10</button>
        <button class="repost" type="button">18</button>
      </footer>
    </div>

    <div class="post">
      <header class="post__header">
        <div class="level-wrap online">
          <div class="avatar red">
            <img src="img/user.jpg" alt="">
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
        <div class="post__info">
          <a class="post__name" href="javascript:void(0)">Медвежонок</a>
          <time class="post__time">15 янв в 21:45</time>
        </div>
      </header>
      <div class="post__content">
        <p>Lorem Ipsum - это текст-"рыба", часто используемый в печати и веб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века.</p>
        <p>В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов.</p>
      </div>
      <footer class="post__footer">
        <button class="like" type="button">18</button>
        <button class="comment" type="button">10</button>
        <button class="repost" type="button">18</button>
      </footer>
    </div>

  </div>

  <div class="panel panel_news">

    <?=$this->render('_locations.php')?>

  </div>
