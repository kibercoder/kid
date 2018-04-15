<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

//Календарь в форме
use yii\bootstrap\Modal;
use kartik\date\DatePicker;

use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Tournament */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs('

    function parseGetParams() {

       var $_GET = {};
       var __GET = window.location.search.substring(1).split("&");
       for(var i=0; i<__GET.length; i++) {
          var getVar = __GET[i].split("=");
          $_GET[getVar[0]] = typeof(getVar[1])=="undefined" ? "" : getVar[1];
       }
       return $_GET;
    }

    var GETArr = parseGetParams();

        $(function(){

        $("#tournament-free, #tournament-type_age").change(function(){
            
            freeType = parseInt($("#tournament-free :selected").val());
            typeAge = parseInt($("#tournament-type_age :selected").val());

            var url_location = window.location.protocol+"//"+window.location.host+window.location.pathname
                + "?id="+GETArr.id+"&type_age="+typeAge+"&free="+freeType;
    
            location.href = url_location;

        });



        $(".input-group").on( "click", ".plus", function( e ) {

            groupHtml = "<div class=\"input-group\"><input type=\"text\" class=\"form-control addplace\" name=\"Tournament[addplace][]\"><span class=\"input-group-btn minus\"><a class=\"btn btn-default\" href=\"#\"><span class=\"glyphicon glyphicon-minus\"></span></a></span></div>";

            $(".input-group:first").after(groupHtml);

            var numberOfplace = 3;

            $("input.addplace").each(function(){

                numberOfplace++;
                $(this).attr("placeholder", numberOfplace+"-е место");

            });

            return false;
        });


        $(document).on( "click", ".minus", function( e ) {

            $(this).parent("div").remove();
            $(this).parent("div").parent("div").remove();

            var numberOfplace = 3;

            $("input.addplace").each(function(){

                numberOfplace++;
                $(this).attr("placeholder", numberOfplace+"-е место");

            });

            return false;
        });


    });'

);

$get = Yii::$app->request->get();

$post = @Yii::$app->request->post()['Tournament'];

?>

<div class="tournament-form">

    <?php $form = ActiveForm::begin([
            'id' => 'form-tournament',
            'options' => ['enctype'=>'multipart/form-data'],
    ]); ?>

    <?php

    if (isset($post['free'])) {
        $model->free = $post['free'];
    }

    if (isset($get['free'])) {
        $model->free = $get['free'];
    }

    echo $form->field($model, 'free')->dropDownList([
                0 => 'Платный турнир', 
                1 => 'Бесплатный', 
    ]) ?>

    <?php 

        if (!empty($post['type_age'])) {
            $model->type_age = $post['type_age'];
        } else if (!empty($get['type_age'])) {
            $model->type_age = $get['type_age'];
        }

        if (!$model->type_age) $model->type_age = 1;

        echo $form->field($model, 'type_age')->dropDownList([ 1 => '6-8 лет', 2 => '9-12 лет', 3 => '13-15 лет', ]); 
    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?=$form->field(
            $model, 'photo',
            ['template' => '<div>{input}</div>{hint}{error}']
        )->fileInput();

    if (preg_match('/\.(?:jp(?:e?g|e|2)|gif|png)$/i', $model->photo)) {
        $src = '/img/tournament/img_tour/'.$model->photo. '?get='.  time();
        echo "<img src='{$src}' width='80' />";
    }

    ?>

    <?= $form->field($model, 'type')->dropDownList([ 'individual' => 'Индивидуальный', 'team' => 'Командный', ]) ?>

    <?php if (!$model->free) : ?>

    <?= $form->field($model, 'cost')->textInput() ?>

    <?= $form->field($model, 'first_place')->textInput() ?>

    <?= $form->field($model, 'second_place')->textInput() ?>

    <?= $form->field($model, 'third_place')->textInput() ?>


    <?php

        if (count($model->addplace) > 0) {

            $inc = 0;

            foreach ($model->addplace as $key => $value) {

                $class = (!$inc) ? 'plus' : 'minus';

                $label = (!$inc) ? 'Дополнительные места' : false;

                $button = Html::a(
                        Html::tag('span', '', [
                            'class' => 'glyphicon glyphicon-'.$class,
                        ]), '#', ['class' => 'btn btn-default addplace']
                );

                echo $form->field($model, 'addplace[]', ['template' => '{label}<div class="input-group">{input}<span class="input-group-btn '.$class.'">'.$button.'</span></div>{hint}{error}'])
                    ->textInput([
                        'class' => "form-control addplace", 
                        "placeholder" => "{$key}-е место",
                        "value" => $value
                    ])->label($label);

                $inc++;

            }

        } else {

            $button = Html::a(
                    Html::tag('span', '', [
                        'class' => 'glyphicon glyphicon-plus',
                    ]), '#', ['class' => 'btn btn-default addplace']
            );

            echo $form->field($model, 'addplace[]', ['template' => '{label}<div class="input-group">{input}<span class="input-group-btn plus">'.$button.'</span></div>{hint}{error}'])
                ->textInput(['class' => "form-control addplace", "placeholder" => "4-е место"])->label('Дополнительные места');
        }

    ?>


    <?= $form->field($model, 'fund')->textInput() ?>

    <?php endif; ?>


    <?php if ($model->free) : ?>

        <?php
            //here we are choise other tour like a tickets
            echo $form->field($model, 'tickets')->dropDownList(ArrayHelper::map(\common\models\Tournament::find()->where(['free' => '0', 'type_age' => $model->type_age])->orderBy('id_t')->all(), 'id_t', 'title'), ['multiple'=>'multiple'])->hint('Для множественного выбора - зажмите Ctrl');
        ?>

    <?php endif; ?>


    <?php

        //https://github.com/kartik-v/yii2-widget-datepicker
        //https://uxsolutions.github.io/bootstrap-datepicker/
        //http://demos.krajee.com/widget-details/datetimepicker

        $model->date_begin = (@$post['date_begin']) ? date("Y-m-d H:i", strtotime(@$post['date_begin'])) : date("Y-m-d H:i", $model->date_begin);

        echo $form->field($model, 'date_begin', ['selectors' => ['input' => '#tournament-date_begin' ], 'options' => [
                'class' => 'input-group-addon kv-date-calendar',
                'value' => 'sfdfsfd',
            ] ])->widget(DateTimePicker::className(),[
                'name' => 'dp_1',
                'type' => DateTimePicker::TYPE_INPUT,
                'options' => ['placeholder' => 'Начало турнира...'],
                'convertFormat' => true,
                'size'=>'md',
                'readonly' => true,

                //'value' => '2018-07-06 10:25',

                //'value'=> ($model->date_begin) ? date("Y-m-d H:i", strtotime($model->date_begin)) :  date("Y-m-d H:i", strtotime($post['date_begin'])),
                'pluginOptions' => [
                    
                    'format' => 'yyyy-MM-dd H:i',
                    'autoclose'=>true,
                    'weekStart'=>1, //неделя начинается с понедельника
                    'startDate'=> 'M',
                    //'endDate'=> '28.01.2018',
                    'todayBtn'=>false, //снизу кнопка "сегодня"
                    'startView' => 3,
                    //'minView' => 2,
                    //'maxView' => 3,
                    //'linkFormat' => 'dd.MM.yyyy', // if inline = true
                    'keyboardNavigation' => true,
                    'showMeridian' => true,
                    'todayHighlight' => true
                    
                ],
                'pluginEvents' => [
                    'changeDate' => 'function(e) {

                    }'
                ]
        ])->label();

    ?>

    <?= $form->field($model, 'max_member')->textInput() ?>


    <?php
    
        echo $form->field($model, 'questions')->dropDownList(ArrayHelper::map(\common\models\TournamentQuestion::find()->where(['type_age' => $model->type_age])->orderBy('id')->all(), 'id', 'question'), ['multiple'=>'multiple'])->hint('Для множественного выбора - зажмите Ctrl');
    ?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
