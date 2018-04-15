<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $profile \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

//Подключаем стили для шаблона signup
use frontend\assets\ProfileEditAsset;
ProfileEditAsset::register($this);

$this->title = 'Редактирование данных';

?>

 <div class="edit">

<p class="edit__title">Редактирование данных</p>

    <?php 
    $form = ActiveForm::begin([
        'id' => 'form-profile',
        'options' => ['enctype'=>'multipart/form-data','class'=>'edit__form' ]
    ]); ?>

  <div class="edit__item">
    <p class="edit__caption">Имя пользователя</p>
    <?= $form->field(
            $profile, 'username',
            ['template' => '{input}{hint}{error}']
        )->textInput(
            [
                'value'=>$model->username,
                'autofocus' => true,
                'placeholder' => 'Имя...',
                'class'=>'edit__input',
                'readonly' => true
            ]
        ) 
    ?>    
  </div>

  <div class="edit__item">
    <p class="edit__caption">Имя</p>
    <?= $form->field(
            $profile, 'first_name',
            ['template' => '{input}{hint}{error}']
        )->textInput(
            [
                'value'=>$model->first_name,
                'autofocus' => true,
                'placeholder' => 'Имя...',
                'class'=>'edit__input'
            ]
        ) 
    ?>    
  </div>
  <div class="edit__item">
    <p class="edit__caption">Фамилия</p>
    <?= $form->field(
            $profile, 'last_name',
            ['template' => '{input}{hint}{error}']
        )->textInput(
            [
                'value'=>$model->last_name,
                'autofocus' => false,
                'placeholder' => 'Фамилия...',
                'class'=>'edit__input'
            ]
        ) 
    ?>   
  </div>
  <?php if(!$model->username){ ?>
  <div class="edit__item">
    <p class="edit__caption">Ник</p>
    <?= $form->field(
        $profile, 'username',
        ['template' => '{input}{hint}{error}']
    )->textInput(
        [
            'value'=>$model->username,
            'placeholder' => 'Ник...',
            'class'=>'edit__input'
        ]
    ) 
    ?>   
  </div>
  <?php } ?>
  <div class="edit__item">
    <p class="edit__caption">Город</p>
    <?= $form->field(
            $profile, 'city',
            ['template' => '{input}{hint}{error}']
        )->textInput(
            [
                'value'=>$model->city,
                'placeholder' => 'Город...',
                'class'=>'edit__input'
            ]
        ) 
    ?>
  </div>
<div class="edit__item">
    <p class="edit__caption">Пол</p>
    <?= $form->field(
            $profile, 'gender',
            ['template' => '{input}{hint}{error}']
        )->textInput(
            [
                'value' =>  $model->gender,
                'placeholder' => 'Пол...',
                'class'=>'edit__input'
            ]
        ) ?>   
  </div>

  <div class="edit__item edit__item_phone">
    <p class="edit__caption">Мобильный телефон</p>
    <?= $form->field(
        $profile, 'phone',
        ['template' => '{input}{hint}{error}']
    )->label(false)->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '+7 (999) 999 99 99',
    ])->textInput(
        [
            'value'=>$model->phone,
            'placeholder' => '+7 (***) ***-**-**',
            'class'=>'edit__input'
        ]
    ) 
    ?>
  </div>
  <?php //if(!$model->email){ ?>
    <div class="edit__item">
        <p class="edit__caption">E-mail</p>
        <?= $form->field(
            $profile, 'email',
            ['template' => '{input}{hint}{error}']
        )->textInput(
            [
                'value' =>  $model->email,
                'placeholder' => 'E-mail...',
                'class'=>'edit__input'
            ]
        ) ?>
    </div>
<?php //} ?>
  <div class="edit__item">
    <p class="edit__caption">Пароль</p>
    <?= $form->field(
        $profile, 'password',
        ['template' => '{input}{hint}{error}']
        )->passwordInput(
        )->input('password', 
            [
                'placeholder' => "Новый пароль", 
                "onpaste" => "return false",
                'class'=>'edit__input'
            ]
        ) 
    ?>    
  </div>
  <div class="edit__item">
    <p class="edit__caption">Повторите пароль</p>
    <?= $form->field(
        $profile, 'confirm_password',
        ['template' => '{input}{hint}{error}']
        )->passwordInput(
        )->input('password', 
            [
                'placeholder' => "Повторите пароль", 
                "onpaste" => "return false",
                'class'=>'edit__input'
        ]) ?>
  </div>
  <div class="edit__item edit__item_avatar" id="choice_avatar">

    <p class="edit__caption">Аватар</p>

    <div class="form-group label-group">  

        <div class="selected_avatar">
            <div class="wrap_circle_user">
                <div class="mini_circle_user">
                        <?php 
                            echo Html::img(
                                    common\models\User::getAvatar($model->id), 
                                    ['alt' => $model->username]
                            );
                        ?>
                    <div class="blank"></div>
                </div>
                <div class="mini_circle blue"></div>
            </div>
        </div>
        
        <div class="choice edit__avatar-btn">Выбрать</div>

        <?php

        $form->field(
            $profile, 'user_avatar',
            ['template' => '{input}{hint}{error}']
        )->textInput([
            'value' => $user_avatar
        ]);
        /*
        $user_avatar = ($modelUserAvatar) ? $modelUserAvatar->id_a : '' ;

         $form->field(
            $modelUserAvatar, 'id_a',
            ['template' => '{input}{hint}{error}']
        )->textInput([
            'value' => $user_avatar
        ])*/?>
        
    </div>

    <?=$form->field(
        $profile, 'avatar',
        ['template' => '{input}{hint}{error}']
    )->fileInput() 
    ?>

 </div>    
    
    <?= Html::submitButton(
                'Сохранить', ['class' => 'edit__save', 'name' => 'signup-button']
            ) ?>   

  </div>



<?php ActiveForm::end(); ?>

</div>
<?php /*
    <div class="mywrap">

        <div class="mycontainer">

            <?php $form = ActiveForm::begin([
                    'id' => 'form-profile',
                    'options' => ['enctype'=>'multipart/form-data']
            ]); ?>
            
                <table id="table_conteiner">
                    <tody>
                        <tr>
                            <td>
                                <?= $form->field(
                                    $profile, 'first_name',
                                    ['template' => '{input}{hint}{error}']
                                )->textInput(
                                    [
                                        'value'=>$model->first_name,
                                        'autofocus' => true,
                                        'placeholder' => 'Имя'
                                    ]
                                ) ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?= $form->field(
                                    $profile, 'last_name',
                                    ['template' => '{input}{hint}{error}']
                                )->textInput(
                                    [
                                        'value'=>$model->last_name,
                                        'autofocus' => false,
                                        'placeholder' => 'Фамилия'
                                    ]
                                ) ?>
                            </td>
                         </tr>
<?php if(!$model->username){ ?>
                        <tr>
                            <td>
                                <?= $form->field(
                                    $profile, 'username',
                                    ['template' => '{input}{hint}{error}']
                                )->textInput(
                                    [
                                        'value'=>$model->username,
                                        'placeholder' => 'Ник'
                                    ]
                                ) ?>
                            </td>
                        </tr>
<?php } ?>
                        <tr>
                            <td>
                                <?= $form->field(
                                    $profile, 'city',
                                    ['template' => '{input}{hint}{error}']
                                )->textInput(
                                    [
                                        'value'=>$model->city,
                                        'placeholder' => 'Город проживания'
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?= $form->field(
                                    $profile, 'phone',
                                    ['template' => '{input}{hint}{error}']
                                )->label(false)->widget(\yii\widgets\MaskedInput::className(), [
                                  'mask' => '+7 (999) 999 99 99',
                                ])->textInput(
                                    [
                                        'value'=>$model->phone,
                                        'placeholder' => 'Телефон'
                                    ]
                                ) ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?= $form->field(
                                    $profile, 'new_password',
                                    ['template' => '{input}{hint}{error}']
                                )->passwordInput(
                                )->input('password', 
                                        [
                                            'placeholder' => "Введите новый пароль", 
                                            "onpaste" => "return false",
                                        ]
                                ) ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?= $form->field(
                                    $profile, 'confirm_password',
                                    ['template' => '{input}{hint}{error}']
                                )->passwordInput(
                                )->input('password', 
                                    [
                                        'placeholder' => "Повторите пароль", 
                                        "onpaste" => "return false",
                                ]) ?>

                            </td>
                        </tr>
 <?php if(!$model->email){ ?>
                        <tr>
                            <td>
                                <?= $form->field(
                                    $profile, 'email',
                                    ['template' => '{input}{hint}{error}']
                                )->textInput(
                                    [
                                        'value' =>  $model->email,
                                        'placeholder' => 'e-mail'
                                    ]
                                ) ?>
                            </td>
                        </tr>
<?php } ?>
                        <tr>                           
                            <td id="choice_avatar">
                                <div class="label-group">
                                    <div class="name_field">
                                        Аватар
                                    </div>

                                    <div class="selected_avatar">
                                        <div class="wrap_circle_user">
                                            <div class="mini_circle_user">
                                                    <?php 
                                                        echo Html::img(
                                                                common\models\User::getAvatar($model->id), 
                                                                ['alt' => $model->username]
                                                        );
                                                    ?>
                                                <div class="blank"></div>
                                            </div>
                                            <div class="mini_circle blue"></div>
                                        </div>
                                    </div>

                                    <div class="choice">
                                        Выбрать
                                    </div>

                                </div>

                                <?=$form->field(
                                    $profile, 'avatar',
                                    ['template' => '{input}{hint}{error}']
                                )->fileInput() 
                                ?>

                                <?= $form->field(
                                    $profile, 'user_avatar',
                                    ['template' => '{input}{hint}{error}']
                                )->textInput([
                                    'value' => $user_avatar
                                ])?>

                            </td>

                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="buttons">
                                    <?= Html::submitButton(
                                        'Сохранить', ['class' => 'btn btn-primary', 'name' => 'signup-button']
                                    ) ?>
                                </div>
                            </td>
                        </tr>
                    </tody>
                </table>

            <?php ActiveForm::end(); ?>

        </div>
    
    </div>

*/ ?>

<?php

    if (count($men_avatars) >= count($women_avatars)) {

        $avatarsMax = $men_avatars;
        $avatarsMin = $women_avatars;
        $genderMax = 'Если ты мальчик';
        $genderMin = 'Если ты девочка';

    } else {
        $avatarsMax = $women_avatars;
        $avatarsMin = $men_avatars; 
        $genderMax = 'Если ты девочка';
        $genderMin = 'Если ты мальчик';
    }

    $contentTable = '';
    $keysUnique = [];

    foreach($avatarsMax as $inc => $ava) {

        if (!in_array($inc, $keysUnique)) {
            $contentTable.= '<tr><td id_ava="'.$ava['id_avatar'].'"><img src="/avatars/165x165/site/'.$ava['avatar_name'].'" /></td>';

            $inc2 = $inc+1;
            $keysUnique[] = $inc;
            $keysUnique[] = $inc2;

            $contentTable.= '<td id_ava="'.$avatarsMax[$inc2]['id_avatar'].'"><img src="/avatars/165x165/site/'.$avatarsMax[$inc2]['avatar_name'].'" /></td>';

            if ($avatarsMin[$inc]) {
                $contentTable.= '<td id_ava="'.$avatarsMin[$inc]['id_avatar'].'"><img src="/avatars/165x165/site/'.$avatarsMin[$inc]['avatar_name'].'" /></td>';
            } else {
                $contentTable.= '<td></td>';
            }

            if ($avatarsMin[$inc2]) {
                $contentTable.= '<td id_ava="'.$avatarsMin[$inc2]['id_avatar'].'"><img src="/avatars/165x165/site/'.$avatarsMin[$inc2]['avatar_name'].'" /></td></tr>';
            } else {
                $contentTable.= '<td></td></tr>';
            }

        }

    }

?>

<table class="list_avatars">
    <thead>
        <tr>
            <th colspan="2"><?=$genderMax?></th>
            <th colspan="2"><?=$genderMin?></th>
        </tr>
    </thead>
    <tbody>
       <?=$contentTable?>
    </tbody>

    <tfoot>
        <tr>
            <td colspan="4">
                <label for="profileform-avatar">
                    Загрузите свою фотографию
                </label>
            </td>
        </tr>
    </tfoot>

</table>