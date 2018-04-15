<?php

namespace common\models;

use Yii;

use yii\web\UploadedFile;
use common\helpers\CheckUploadFile;
use common\helpers\Translit;
use common\models\TournamentLinkQuestion;
use common\models\TournamentPlaces;
use common\models\Tickets;


/**
 * This is the model class for table "tournament".
 *
 * @property int $id_t Турнир
 * @property string $title Название
 * @property string $photo Фото
 * @property string $type Тип
 * @property double $cost Стоимость
 * @property int $fund Призовой фонд
 * @property double $first_place Первое место
 * @property double $second_place Второе место
 * @property double $third_place Третье место
 * @property int $date_begin Начало
 * @property int $date_end Конец
 * @property string $type_age Возраст
 * @property int $max_member Колличество участников
 *
 * @property TournamentQuestion[] $tournamentQuestions
 */
class Tournament extends \yii\db\ActiveRecord
{

    public $questions;
    public $tickets;
    public $addplace;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tournament';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {

        return [
            [
                    ['title', 'type', 'type_age', 'cost', 'first_place', 'second_place', 'third_place', 'max_member', 'free'], 'required'
            ],
            [['type'], 'string'],


            [['cost', 'first_place', 'second_place', 'third_place', 'max_member'], 'integer'],
            [ ['cost', 'first_place', 'second_place', 'third_place'], 'number', 'min' => 1],
            [['title'], 'string', 'max' => 255],


            [['fund'], 'common\components\validators\FundValidator'],
            [['date_begin'], 'common\components\validators\DateRangeValidator'],
            [['max_member'], 'common\components\validators\MembersValidator'],
            [['tickets'], 'common\components\validators\TicketsValidator'],
            [['questions'], 'common\components\validators\QuestionsValidator'],

            /*[['photo'], 'required', 'when' => function($model) {
                return $model->photo == '';
            },'whenClient' => "function (attribute, value) {
                return $('input#tournament-photo').attr('value') == undefined;
            }"],*/

            [
                ['photo'], 'file', 
                'extensions' => 'jpg, png, gif, jpeg', 
                'wrongExtension' => 'Только jpg, png, gif',
                'maxSize' => Yii::$app->params['max_filesize_img'],
                'minSize' => 10000, //10 кб
                'tooBig' => 'Максимальный файл 10мб',
                'tooSmall' => 'Минимальный файл - 10кб', 
                //'skipOnEmpty' => true
            ],

            ['free', 'in', 'range' => [0, 1]],

            ['type_age', 'in', 'range' => [1, 2, 3]],

        ];
    }



    public function photo_required($attribute_name, $params)
    {
        if (empty($this->photo))
        {
            $this->addError($attribute_name, 'Фото обязательно');

            return false;
        }

        return true;
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_t' => 'Турнир',
            'free' => 'Платный / Бесплатный',
            'title' => 'Название',
            'photo' => 'Фото турнира',
            'type' => 'Индивдуальный / Командный',
            'cost' => 'Стоимость в кидкойнах',
            'fund' => 'Призовой фонд в кидкойнах',
            'first_place' => 'Первое место',
            'second_place' => 'Второе место',
            'third_place' => 'Третье место',
            'date_begin' => 'Начало турнира',
            'type_age' => 'Возраст',
            'max_member' => 'Колличество участников',
            'questions' => 'Вопросы для турнира',
            'tickets' => 'Билеты на турниры'
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTournamentQuestions()
    {
        return $this->hasMany(TournamentQuestion::className(), ['id_q' => 'id_t']);
    }

    public function updateTournament($model)
    {

        $post = Yii::$app->request->post()['Tournament'];

        $model->date_begin = strtotime($model->date_begin);

        $tourPhotoSql = self::find('id_t')->where(['id_t' => $model->id_t])->one();

        $old_photo = $tourPhotoSql->photo;

        $model->photo = UploadedFile::getInstance($model, 'photo');

        if ($model->photo && preg_match('/\.(?:jp(?:e?g|e|2)|gif|png)$/i', $model->photo->name)) {

            $existFile = Yii::$app->params['path_frontend'].'img/tournament/img_tour/'.$old_photo;

        
            if (file_exists($existFile)){
                //echo $existFile;
                unlink($existFile);
            }

                        //die;

            $uploadFile = new CheckUploadFile();

            $photo = $uploadFile->checkImage(
                Yii::$app->params['max_filesize_img'], 
                Yii::$app->params['path_frontend'].'/img/tournament/img_tour/',
                70,
                70,
                $model->photo,
                ['jpg','jpeg','gif','png'],
                $model->id_t
            );

            if ($photo['success']) {
                $model->photo = $photo['namefile'];
            } else {
                return false;
            }

        } else {
            $model->photo = $old_photo;
        }



        if ($model->save(false)) {


            TournamentLinkQuestion::deleteAll(['id_t' => $model->id_t]);

            $id_t = $model->id_t;

            foreach ($post['questions'] as $key => $id_q) {

                $modelTourLinkQ = new TournamentLinkQuestion();
                $modelTourLinkQ->id_t = $id_t;
                $modelTourLinkQ->id_q = $id_q;
                //Поля $id_t и $id_q - вместе должны быть уникальной парой ключей
                $modelTourLinkQ->save();
                
            }

            Tickets::deleteAll(['id_t1' => $model->id_t]);

            //If tour is free then add tickets like the other tours
            if ($model->free) {

                foreach ($post['tickets'] as $key => $id_tiket) {

                    $modelTickets = new Tickets();

                    $modelTickets->id_t1 = $id_t;
                    $modelTickets->id_t2 = $id_tiket;

                    $modelTickets->save();
                            
                }

            }


            TournamentPlaces::deleteAll(['id_t' => $model->id_t]);

            //If array of $addplaces we are add their
            $addplaces = (!empty($post['addplace'])) ? array_diff($post['addplace'], array('')) : [];

            if (count($addplaces) > 0) {

                $place = 3;
                foreach ($addplaces as $key => $value) {

                    if (is_numeric($value)) {

                        $place++;

                        $modelTournamentPlaces = new TournamentPlaces();

                        $modelTournamentPlaces->id_t = $id_t;
                        $modelTournamentPlaces->place = $place;
                        $modelTournamentPlaces->value = $value;

                        $modelTournamentPlaces->save();

                    }

                }
            }


            return true;

        } else {
            return false;
        }


    }


    public function createNewTournament()
    {

        $post = Yii::$app->request->post()['Tournament'];

        $this->photo = UploadedFile::getInstance($this, 'photo');

        $this->date_begin = strtotime($this->date_begin);

        if ($this->photo) {

            $tourPhotoSql = self::find('id_t')->orderBy(['id_t' => SORT_DESC])->one();

            (int)$tourPhotoSql->id_t++;

            $uploadFile = new CheckUploadFile();

            $photo = $uploadFile->checkImage(
                Yii::$app->params['max_filesize_img'], 
                Yii::$app->params['path_frontend'].'/img/tournament/img_tour/',
                70,
                70,
                $this->photo,
                ['jpg','jpeg','gif','png'],
                $tourPhotoSql->id_t
            );

            if ($photo['success']) {

                $this->photo = $photo['namefile'];
                
            } else {
                return false;
            }

        }


        if ($this->save(false)) {

            $id_t = $this->id_t;

            foreach ($post['questions'] as $key => $id_q) {

                $modelTourLinkQ = new TournamentLinkQuestion();
                $modelTourLinkQ->id_t = $id_t;
                $modelTourLinkQ->id_q = $id_q;
                //Поля $id_t и $id_q - вместе должны быть уникальной парой ключей
                $modelTourLinkQ->save();
                
            }

            //If tour is free then add tickets like the other tours
            if ($this->free) {
                foreach ($post['tickets'] as $key => $id_tiket) {

                    $modelTickets = new Tickets();

                    $modelTickets->id_t1 = $id_t;
                    $modelTickets->id_t2 = $id_tiket;

                    $modelTickets->save();
                            
                }
            }


            //If array of $addplaces we are add their
            $addplaces = (!empty($post['addplace'])) ? array_diff($post['addplace'], array('')) : [];

            if (count($addplaces) > 0) {

                $place = 3;
                foreach ($addplaces as $key => $value) {

                    if (is_numeric($value)) {

                        $place++;

                        $modelTournamentPlaces = new TournamentPlaces();

                        $modelTournamentPlaces->id_t = $id_t;
                        $modelTournamentPlaces->place = $place;
                        $modelTournamentPlaces->value = $value;

                        $modelTournamentPlaces->save();

                    }

                }
            }

            return true;

        } else {
            return false;
        }


    }

}
