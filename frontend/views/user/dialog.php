<?php

use yii\helpers\Html;
use common\models\User;

/* @var $this yii\web\View */

//Подключаем стили для шаблона index
use frontend\assets\DialogAsset;
DialogAsset::register($this);
$user = $this->params['user'];
$this->title = 'Диалог - '.$user->username;

$days = [];
if(count($messages)){
  foreach($messages as $m => $message){ 
    $created = new DateTime($message->created);
    $dayCreated = $created->format('Y-m-d');
    $days[$dayCreated][] = $message; 
  }
}
?>

<div class="dialog">

  <div class="dialog__body">
  <?php if(count($days)){ ?>
    <?php foreach($days as $day => $dayMessages){ ?>
      <div class="dialog__one-day">

        <time class="dialog__date"><?= $day ?></time>
        <?php foreach($dayMessages as $m => $message){
          if($message->to_user_id == $user->id) $opponent = $message->from;
          if($message->from_user_id == $user->id) $opponent = $message->to;
          $messageClass = ($message->from_user_id == $user->id) ? 'message_user' : 'message_friend';  
          $messageOwner = ($message->from_user_id == $user->id) ? $user : $opponent ;
          $skipAvatar = false;
          $skipEnd = false; 
          if($m){
            $skipAvatar = ($dayMessages[$m-1]->from->id == $messageOwner->id) ? true : false ;
          } 
          if(isset($dayMessages[$m+1])){
            $skipEnd = ($dayMessages[$m+1]->from->id == $messageOwner->id) ? true : false ;
          }          
        ?>
          <?php if(!$skipAvatar){ ?>
          <div class="message <?= $messageClass ?>">
            <div class="level-wrap">
              <div class="avatar <?= $messageOwner->party; ?>">
              <?php 
                  echo Html::img(
                          common\models\User::getAvatar($messageOwner->id), 
                          ['alt' =>  $messageOwner->username]
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

            <div class="message__body">
              <a class="message__username" href="javascript:void(0)"><?= $messageOwner->username; ?></a>
              <ul class="message__list">
          <?php } ?>
              <li class="message__item">
                <p class="message__text"><?= $message->text; ?>.</p>
                <time class="message__time"><?php   
                $created = new DateTime($message->created);
                echo $created->format('H:i'); ?></time>
              </li>
          <?php if(!$skipEnd){ ?>
              </ul>
            </div>
          </div> 
          <?php } ?>
        <?php } ?>
      </div>
    <?php } ?>
  <?php } ?>  

  <!--
    <div class="dialog__one-day">

      <time class="dialog__date">Воскресенье, 11 февраля 2018</time>

      <div class="message message_user">
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
        <div class="message__body">
          <a class="message__username" href="javascript:void(0)">Медвежонок</a>
          <ul class="message__list">
            <li class="message__item">
              <p class="message__text">Извини, но не получится..</p>
              <time class="message__time">21:05</time>
            </li>
            <li class="message__item">
              <p class="message__text">Хочу пойти на выборы завтра</p>
              <time class="message__time">21:10</time>
            </li>
            <li class="message__item">
              <img class="message__image" src="img/post1.jpg" alt="">
              <time class="message__time">21:10</time>
            </li>
          </ul>
        </div>
      </div>

      <div class="message message_friend">
        <div class="level-wrap">
          <div class="avatar red">
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
        <div class="message__body">
          <a class="message__username" href="javascript:void(0)">Грейс Келли</a>
          <ul class="message__list">
            <li class="message__item">
              <p class="message__text">Давай завтра поедем на шашлыки к кириллу</p>
              <time class="message__time">21:05</time>
            </li>
            <li class="message__item">
              <p class="message__text">Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века.</p>
              <time class="message__time">21:10</time>
            </li>
          </ul>
        </div>
      </div>

    </div>

    <div class="dialog__one-day">

      <time class="dialog__date">Понедельник, 12 февраля 2018</time>

      <div class="message message_user">
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
        <div class="message__body">
          <a class="message__username" href="javascript:void(0)">Грейс Келли</a>
          <ul class="message__list">
            <li class="message__item">
              <p class="message__text">Давай завтра поедем на шашлыки к кириллу</p>
              <time class="message__time">21:05</time>
            </li>
            <li class="message__item">
              <p class="message__text">Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века.</p>
              <time class="message__time">21:10</time>
            </li>
          </ul>
        </div>
      </div>

    </div>

  </div>
-->
  <div class="dialog__send-message">
    <div class="edit-message">
      <a class="edit-message__username" href="javascript:void(0)">Грейс Келли</a>
      <p class="edit-message__text">Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века.</p>
      <button class="edit-message__close" type="button"></button>
    </div>
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
    <form class="dialog__form" id="message_form">
      <textarea class="dialog__input" type="text" id="message_txt" placeholder="Напиши что-нибудь..."></textarea>
      <div class="emoji-container">
        <span class="more-emoji"></span>
        <div class="emoji-wrapper">
          <img class="emoji__item" src="img/emoji1.png" alt="">
          <img class="emoji__item" src="img/emoji2.png" alt="">
          <img class="emoji__item" src="img/emoji3.png" alt="">
          <img class="emoji__item" src="img/emoji4.png" alt="">
          <img class="emoji__item" src="img/emoji5.png" alt="">
          <img class="emoji__item" src="img/emoji6.png" alt="">
          <img class="emoji__item" src="img/emoji7.png" alt="">
          <img class="emoji__item" src="img/emoji8.png" alt="">
          <img class="emoji__item" src="img/emoji1.png" alt="">
          <img class="emoji__item" src="img/emoji2.png" alt="">
          <img class="emoji__item" src="img/emoji3.png" alt="">
          <img class="emoji__item" src="img/emoji4.png" alt="">
          <img class="emoji__item" src="img/emoji5.png" alt="">
          <img class="emoji__item" src="img/emoji6.png" alt="">
          <img class="emoji__item" src="img/emoji7.png" alt="">
          <img class="emoji__item" src="img/emoji8.png" alt="">
          <img class="emoji__item" src="img/emoji1.png" alt="">
          <img class="emoji__item" src="img/emoji2.png" alt="">
          <img class="emoji__item" src="img/emoji3.png" alt="">
          <img class="emoji__item" src="img/emoji4.png" alt="">
          <img class="emoji__item" src="img/emoji5.png" alt="">
          <img class="emoji__item" src="img/emoji6.png" alt="">
          <img class="emoji__item" src="img/emoji7.png" alt="">
          <img class="emoji__item" src="img/emoji8.png" alt="">
          <img class="emoji__item" src="img/emoji1.png" alt="">
          <img class="emoji__item" src="img/emoji2.png" alt="">
          <img class="emoji__item" src="img/emoji3.png" alt="">
          <img class="emoji__item" src="img/emoji4.png" alt="">
          <img class="emoji__item" src="img/emoji5.png" alt="">
          <img class="emoji__item" src="img/emoji6.png" alt="">
          <img class="emoji__item" src="img/emoji7.png" alt="">
          <img class="emoji__item" src="img/emoji8.png" alt="">
          <img class="emoji__item" src="img/emoji1.png" alt="">
          <img class="emoji__item" src="img/emoji2.png" alt="">
          <img class="emoji__item" src="img/emoji3.png" alt="">
          <img class="emoji__item" src="img/emoji4.png" alt="">
          <img class="emoji__item" src="img/emoji5.png" alt="">
          <img class="emoji__item" src="img/emoji6.png" alt="">
          <img class="emoji__item" src="img/emoji7.png" alt="">
          <img class="emoji__item" src="img/emoji8.png" alt="">
        </div>
      </div>
      <div class="emoji">
        <img class="emoji__item" src="img/emoji1.png" alt="">
        <img class="emoji__item" src="img/emoji2.png" alt="">
        <img class="emoji__item" src="img/emoji3.png" alt="">
        <img class="emoji__item" src="img/emoji4.png" alt="">
        <img class="emoji__item" src="img/emoji5.png" alt="">
        <img class="emoji__item" src="img/emoji6.png" alt="">
        <img class="emoji__item" src="img/emoji7.png" alt="">
        <img class="emoji__item" src="img/emoji8.png" alt="">
      </div>
      <button class="dialog__affix" type="button"></button>
      <button class="dialog__send" id="send_message" type="button" data-userid="<?= $id ?>">Отправить</button>
      <input type="file" id="message_file" accept="image/jpeg,image/png,image/gif,text/plain">
    </form>
  </div>

  <div class="dialog__action">
      <button class="dialog__action-btn" type="button">Переслать<span class="action-messages"></span></button>
      <button class="dialog__action-btn" type="button">Править<span class="action-messages"></span></button>
      <button class="dialog__action-btn" type="button">Удалить<span class="action-messages"></span></button>
      <button class="dialog__action-btn" type="button">Отмена</button>
  </div>

</div>

<div class="modal modal_forward">
  <div class="modal__wrap">
    <div class="forward__header">
      <p class="forward__title">Переслать</p>
      <button class="forward__close" type="button"></button>
    </div>
    <form class="forward__search">
      <input class="forward__input" type="text" placeholder="Поиск...">
      <button class="forward__search-btn" type="submit"></button>
    </form>
    <div class="forward__list">
      <div class="forward__item">
        <p class="forward__username">Грейс Келли</p>
        <p class="forward__text">Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века.</p>
      </div>
      <div class="forward__item">
        <p class="forward__username">Грейс Келли</p>
        <div class="forward__text-users">
          <p class="forward__prefix">Вы:</p>
          <p class="forward__text">Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века.</p>
        </div>
      </div>
      <div class="forward__item">
        <p class="forward__username">Вероничка</p>
        <p class="forward__text">Давай завтра поедем на шашлыки к кириллу</p>
      </div>
      <div class="forward__item">
        <p class="forward__username">Вася Иванов</p>
        <p class="forward__text">Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века.</p>
      </div>
      <div class="forward__item">
        <p class="forward__username">Зайчонок</p>
        <p class="forward__text">Давай завтра поедем на шашлыки к кириллу</p>
      </div>
      <div class="forward__item">
        <p class="forward__username">Юзерсоченьдлинным Именем</p>
        <p class="forward__text">Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века.</p>
      </div>
    </div>
  </div>
</div>