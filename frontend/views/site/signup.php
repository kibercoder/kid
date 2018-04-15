<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use yii\captcha\CaptchaAction;

//Подключаем стили для шаблона signup
use frontend\assets\SignupAsset;
SignupAsset::register($this);

//Календарь в форме
use yii\bootstrap\Modal;
use kartik\date\DatePicker;

$this->title = 'Регистрация';
//$this->params['breadcrumbs'][] = $this->title;

$post = @Yii::$app->request->post()['SignupForm'];
$get = Yii::$app->request->get();

$valBirthdate = (@$post['birthdate']) ? @$post['birthdate'] : date("d.m.Y", @$get['birthdate']);

$model->confirm = @$post['confirm'];
$model->accept_rules = @$post['accept_rules'];

$param_startDate = strtotime(Yii::$app->params['start_date']);
$param_endDate = strtotime(Yii::$app->params['end_date']);


$validate = (($param_startDate > @$get['birthdate']) || ($param_endDate < @$get['birthdate'])) && strlen(@$get['birthdate']) > 0;
                    


if ($validate) {

    $this->registerJs(

        '$(function(){

            $(".field-signupform-birthdate .help-block").text("Введите дату рождения от 7 до 16 лет");

            $("#signupform-birthdate").val("");

        });'

    );

}

?>


<script type="text/javascript">
    //эТИ ПЕРЕМЕННЫЕИСПОЛЬЗУЮТСЯ В ФАЙЛЕ js/handler.js
    var id_avatar_src = '<?=$id_avatar_src?>';
    var id_avatar_val = '<?=$id_avatar_val?>';
</script>

    <div class="mywrap">

       <div id="header">

            <div class="row">
            
                <div id="ribbon" class="col1">
                    
                    <a href="#" id="logo">
                        <img src="/img/logo1.png">
                    </a>

                </div>
                
                <div class="col2">
                    
                    <img id="balun" src="/img/balun.png" />

                    <div class="balun">
                        Добро пожаловать в Кидворк! По правилам нашего города все гости должны пройти регистрацию. 
                        После того, как ты введешь свои данные, мы предоставим тебе дом в Кидворке на два дня 
                        совершенно бесплатно. Ты сможешь прогуляться по нашему городку, поучиться некоторым 
                        профессиям и даже устроиться на работу. А если захочешь стать постоянным жителем Кидворка и 
                        получить доступ ко всем профессиям, работать и зарабатывать кидкоины, обменивать их на 
                        ценные вещи в нашем магазине, то тебе просто нужно будет платить за свой дом 300 рублей в 
                        месяц. И все! Ты будешь полноценным жителем Кидворка и получишь доступ ко всем его 
                        удивительным возможностям.
                    </div>

                </div>

           
            </div>
     
        </div>

        <div class="mycontainer">

            <?php $form = ActiveForm::begin([
                    'id' => 'form-signup',
                    'options' => ['enctype'=>'multipart/form-data']
            ]); ?>
            
                <table id="table_conteiner">
                    <colgroup>
                        <!-- Для первых 1ой ширина 390 -->
                        <col span="2" width="395" />
                        <!-- Для 2-й ячейки ширина 375 -->
                        <!--col span="1" width="375" /-->
                        <!-- Для третьей 405 -->
                        <col span="1" width="375" />
                    </colgroup>
                    <tody>
                        <tr>

                            <td>
                                <?= $form->field(
                                    $model, 'first_name',
                                    ['template' => '{input}{hint}{error}']
                                )->textInput(
                                    [
                                        'value'=> (@$post['first_name']) ? @$post['first_name'] : @$get['first_name'],
                                        'autofocus' => true,
                                        'placeholder' => 'Имя'
                                    ]
                                ) ?>
                            </td>

                            <td>
                                <?= $form->field(
                                    $model, 'last_name',
                                    ['template' => '{input}{hint}{error}']
                                )->textInput(
                                    [
                                        'value'=> (@$post['last_name']) ? @$post['last_name'] : @$get['last_name'],
                                        'autofocus' => false,
                                        'placeholder' => 'Фамилия'
                                    ]
                                ) ?>
                            </td>
                            
                            <td id="choice_avatar">
                
                                <div class="label-group">
                                    <div class="name_field">
                                        Аватар
                                    </div>

                                    <div class="selected_avatar">
                                        
                                        <div class="wrap_circle_user">

                                            <div class="mini_circle_user">

                        <img src="/avatars/165x165/site/<?=$id_avatar_src?>" />
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
                                    $model, 'avatar',
                                    ['template' => '{input}{hint}{error}']
                                )->fileInput() 
                                ?>

                                <?= $form->field(
                                    $model, 'user_avatar',
                                    ['template' => '{input}{hint}{error}']
                                )->textInput([
                                    'value' => $id_avatar_val
                                ])?>

                            </td>

                        </tr>

                        <tr>
                            <td>
                                <?= $form->field(
                                    $model, 'username',
                                    ['template' => '{input}{hint}{error}']
                                )->textInput(
                                    [
                                        'value'=>$post['username'],
                                        'placeholder' => 'Ник'
                                    ]
                                ) ?>
                            </td>

                            <td>

                                <?php

                                    //https://github.com/kartik-v/yii2-widget-datepicker
                                    //https://uxsolutions.github.io/bootstrap-datepicker/
                                //http://demos.krajee.com/widget-details/datetimepicker
                                    
                                    $date = new DateTime();
                                    $date->modify('-16 year');
                                    $date->modify('-1 month');
                                    $startDate = $date->format('Y, m, d');

                                    $date2 = new DateTime();
                                    $date2->modify('-7 year');
                                    $date2->modify('-1 month');
                                    $endDate = $date2->format('Y, m, d');
                                    
                                    echo $form->field($model, 'birthdate')->widget(DatePicker::classname(), [
                                        'options' => [
                                            'placeholder' => 'Дата рождения ...', 
                                            'class' => 'input-group-addon kv-date-calendar',
                                            'value' => $valBirthdate,

                                        ], //класс  input-group-addon kv-date-calendar - 
                                            //нужен для правильной работы на сенсорных устроиствах
                                            //Это класс взят с кнопки - pickerButton
                                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                        'size' => 'xs',
                                        'readonly' => true,
                                        'pickerButton' => false,
                                        //'pickerButton' => ['icon' => 'calendar'],
                                        'removeButton' => false,
                                        'disabled' => false,
                                        'layout' => '{remove}{input}{picker}',
                                        'pluginOptions' => [
                                            'autoclose' =>true,
                                            'format' => 'dd.mm.yyyy',
                                            'weekStart' => 1, //неделя начинается с понедельника
                                            //'startDate' => $startDate,
                                            'endDate' => '0d',
                                            //'endDate' => $endDate,
                                            'todayBtn' => true, //снизу кнопка "сегодня"
                                            'startView' => 2,
                                            'minViewMode' => 0,
                                            'maxViewMode' => 2,
                                            //'linkFormat' => 'dd.MM.yyyy', // if inline = true
                                            'keyboardNavigation' => true,
                                            'showMeridian' => true,
                                            'todayHighlight' => true

                                        ],
                                        'pluginEvents' => [
                                            'changeDate' => 'function(e) {
                    startDate = new Date('.$startDate.').getTime();
                    endDate = new Date('.$endDate.').getTime();
                    choiceDate = new Date(e.date.toDateString()).getTime();

                                //alert(e.date.toDateString());

                                //alert(endDate);
                                //alert(choiceDate);

                                if (startDate > choiceDate || endDate < choiceDate) {

                                    $("#signupform-birthdate").val("");
                                    $(".field-signupform-birthdate .help-block-error").text("Только для детей от 7 до 18 лет444");

                                    return false;

                                }

                                                //alert(e.date.getTime());
                                                //alert(e.date.getFullYear()); // год
                                                //alert(e.date.getMonth());
                                                //alert(e.date.getDate());  //день
                                                
                                            }',

                                            'clearDate' => 'function(e) {

                                    $(".field-signupform-birthdate .help-block-error").text("Только для детей от 7 до 18 лет333");

                                            }',
                                            'changeYear' => 'function(e) {
                                                //alert(e.date);
                                            }',
                                            'hide' => 'function(e) {

                                            }',
                                        ]
                                    ])->label(false);

                                ?>

                            </td>

                            <td>
                                <label for="signupform-confirm" class="checkbox_label">
                            
            <?= $form->field($model, 'confirm',
                ['checkboxTemplate'=>"Я подтверждаю достоверность указанных мною данных{input}<i></i>{error}{hint}"])->checkbox();
            ?> 

                                </label>
                            </td>
                        </tr>

                        <tr>

                            <td>
                                <?= $form->field(
                                    $model, 'city',
                                    ['template' => '{input}{hint}{error}']
                                )->textInput(
                                    [
                                        'value'=>(@$post['city']) ? @$post['city'] : @$get['city'],
                                        'placeholder' => 'Город проживания'
                                    ]
                                ) ?>
                            </td>

                            <td>
                                <?= $form->field(
                                    $model, 'phone',
                                    ['template' => '{input}{hint}{error}']
                                )->label(false)->widget(\yii\widgets\MaskedInput::className(), [
                                  'mask' => '+7 (999) 999 99 99',
                                ])->textInput(
                                    [
                                        'value'=> @$post['phone'],
                                        'placeholder' => 'Телефон'
                                    ]
                                ) ?>
                            </td>

                            <td>
                                <label for="signupform-accept_rules" class="checkbox_label">

            <?= $form->field($model, 'accept_rules',
                ['checkboxTemplate'=>"Я ознакомился и принимаю <u>правила сайта kidwork.ru</u>{input}<i></i>{error}{hint}"])->checkbox();
            ?> 

                                </label>
                            </td>
                        </tr>
                        
                        <tr>

                            <td>
                                <?= $form->field(
                                    $model, 'password',
                                    ['template' => '{input}{hint}{error}']
                                )->passwordInput(
                                )->input('password', 
                                        [
                                            'placeholder' => "Введите пароль", 
                                            "onpaste" => "return false",
                                            'value' => @$post['password'],
                                        ]
                                ) ?>
                            </td>

                            <td>
                                <?= $form->field(
                                    $model, 'confirm_password',
                                    ['template' => '{input}{hint}{error}']
                                )->passwordInput(
                                )->input('password', 
                                    [
                                        'placeholder' => "Повторите пароль", 
                                        "onpaste" => "return false",
                                        'value' => @$post['confirm_password'],
                                ]) ?>

                            </td>

                            <td>
                                <label class="checkbox_label">
                                    Войти через социальные сети.
                                </label>
                        
                                <?php
                                    if (Yii::$app->getSession()->hasFlash('error')) {
                                        echo '<div class="alert alert-danger">'.Yii::$app->getSession()->getFlash('error').'</div>';
                                    }
                                ?>

                                <label class="auth_label">
                                    <?php echo \nodge\eauth\Widget::widget(['action' => 'site/login']); ?>
                                </label>

                            </td>
                        </tr>

                        <tr>

                            <td>
                                <?= $form->field(
                                    $model, 'email',
                                    ['template' => '{input}{hint}{error}']
                                )->textInput(
                                    [
                                        'value' => @$post['email'],
                                        'placeholder' => 'e-mail'
                                    ]
                                ) ?>
                            </td>
                            <td id="captcha_user" colspan="2">
                                <?= $form->field(
                                        $model, 'verifyCode'
                                    )->widget(
                                    yii\captcha\Captcha::className(),
                                    [
                                        'options' => [
                                            'value' => @$post['verifyCode'],
                                            'placeholder' => 'Введите буквы'
                                        ],
                                        //'captchaAction' => 'user/captcha',
                                        'template' => '{image}{input}'
                                    ]
                                )->label(false) ?>
                            </td>

                        </tr>

                        <tr>
                            <td colspan="2">
                                <div class="buttons">
                                    <?= Html::submitButton(
                                        'Сохранить', ['class' => 'btn btn-primary', 'name' => 'signup-button']
                                    ) ?>
                                    <?= Html::a('На главную', ['/']) ?>
                                </div>
                            </td>
                            <td></td>
                        </tr>

                    </tody>
                </table>

            <?php ActiveForm::end(); ?>

        </div>
    
    </div>



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
                <label for="signupform-avatar">
                    Загрузите свою фотографию
                </label>
            </td>
        </tr>
    </tfoot>

</table>