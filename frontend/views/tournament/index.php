<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

//Подключаем стили для шаблона signup
use frontend\assets\TournamentsAsset;
TournamentsAsset::register($this);

use common\models\Tickets;

$this->title = 'Турниры';
//$this->params['breadcrumbs'][] = $this->title;


$this->registerJs('

    $(document).on( "click", "#tabs div", function( e ) {
    
        getId = $(this).attr("id");

        if (getId == "blue") {
            $("#tabs div#blue").css("zIndex", 3);
            $("#tabs div#green").css("zIndex", 1);
            $("#tabs div#yellow").css("zIndex", 0);
        }

        if (getId == "green") {
            $("#tabs div#green").css("zIndex", 3);
            $("#tabs div#blue").css("zIndex", 1);
            $("#tabs div#yellow").css("zIndex", 0);
        }

        if (getId == "yellow") {
            $("#tabs div#yellow").css("zIndex", 3);
            $("#tabs div#blue").css("zIndex", 0);
            $("#tabs div#green").css("zIndex", 1);
        }

        $(".table_conteiner tbody").hide();

        $(".table_conteiner tbody."+getId).show();

    });
');


?>

<section id="wrapper">
    
    <header id="header">

    </header>

    <section id="my_conteiner">
        
        <div id="tabs">
            <div id="blue">
                <span>6-8</span> лет
            </div>
            <div id="green">
                <span>9-12</span> лет
            </div>
            <div id="yellow">
                <span>13-15</span> лет
            </div>
            <a id="button_main" href="#"></a>
        </div>


        <table class="table_conteiner" cellpadding="0" cellspacing="0">
            
            <thead>
                <tr>
                    <th>НАЧАЛО</th>
                    <th>ТИП</th>
                    <th>СТОИМОСТЬ</th>
                    <th>НАЗВАНИЕ</th>
                    <th>ПРИЗОВОЙ ФОНД</th>
                    <th>РЕГИСТРАЦИЯ</th>
                </tr>
            </thead>

            <tbody class="blue">

            <?php foreach ($mTournament1 as $tour) : ?>
                <tr tour_id="<?=$tour['id_t'];?>">
                    <td>
                        <?=date("Y-m-d H:i", $tour['date_begin']);?>
                    </td>
                    <td class="<?=$tour['type'];?>_tournament">
                        <?=($tour['type'] == 'individual') ? "ИНДИВИДУАЛЬНЫЙ" : "Командный";?>
                    </td>
                    <td>
                        <?php if ($tour['free']): ?>
                            Бесплатный
                        <?php else : ?>
                            <?=$tour['cost'];?> КИДКОИНОВ
                        <?php endif; ?>
                    </td>
                    <td class="name_tournament">
                        <?=$tour['title'];?>
                    </td>
                    <td>
                        <?php if ($tour['free']): ?>
                        
                            <?php
                               echo Tickets::find()->where(['id_t1' => $tour['id_t']])->count();
                            ?> билетов

                        <?php else : ?>
                            <?=$tour['fund'];?> КИДКОИНОВ
                        <?php endif; ?>
                    </td>
                    <td class="reg">
                        <a href="#"></a>
                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>

            <tbody class="green">

            <?php foreach ($mTournament2 as $tour) : ?>
                <tr tour_id="<?=$tour['id_t'];?>">
                    <td>
                        <?=date("Y-m-d H:i", $tour['date_begin']);?>
                    </td>
                    <td class="<?=$tour['type'];?>_tournament">
                        <?=($tour['type'] == 'individual') ? "ИНДИВИДУАЛЬНЫЙ" : "Командный";?>
                    </td>
                    <td>
                        <?php if ($tour['free']): ?>
                            Бесплатный
                        <?php else : ?>
                            <?=$tour['cost'];?> КИДКОИНОВ
                        <?php endif; ?>
                    </td>
                    <td class="name_tournament">
                        <?=$tour['title'];?>
                    </td>
                    <td>

                        <?php if ($tour['free']): ?>
                        
                        <?php
                           echo Tickets::find()->where(['id_t1' => $tour['id_t']])->count();
                        ?> билетов

                        <?php else : ?>
                            <?=$tour['fund'];?> КИДКОИНОВ
                        <?php endif; ?>

                    </td>
                    <td class="reg">
                        <a href="#"></a>
                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>

            <tbody class="yellow">

                <?php foreach ($mTournament3 as $tour) : ?>
                <tr tour_id="<?=$tour['id_t'];?>">
                    <td>
                        <?=date("Y-m-d H:i", $tour['date_begin']);?>
                    </td>
                    <td class="<?=$tour['type'];?>_tournament">
                        <?=($tour['type'] == 'individual') ? "ИНДИВИДУАЛЬНЫЙ" : "Командный";?>
                    </td>
                    <td>
                        <?php if ($tour['free']): ?>
                            Бесплатный
                        <?php else : ?>
                            <?=$tour['cost'];?> КИДКОИНОВ
                        <?php endif; ?>
                    </td>
                    <td class="name_tournament">
                        <?=$tour['title'];?>
                    </td>
                    <td>
                        <?php if ($tour['free']): ?>
                        
                            <?php
                               echo Tickets::find()->where(['id_t1' => $tour['id_t']])->count();
                            ?> билетов

                        <?php else : ?>
                            <?=$tour['fund'];?> КИДКОИНОВ
                        <?php endif; ?>
                    </td>
                    <td class="reg">
                        <a href="#"></a>
                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>

        </table>




    </section>

</section>

<div id="wraper_window"></div>
<div class="wraper_window2"></div>