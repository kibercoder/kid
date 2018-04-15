<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "questionAnswerPhoto".
 *
 * @property int $id
 * @property string $answerPhoto1 Ответ 1
 * @property string $answerPhoto2 Ответ 2
 * @property string $answerPhoto3 Ответ 3
 * @property string $answerPhoto4 Ответ 4
 * @property string $answerPhoto5 Ответ 5
 * @property string $answerPhoto6 Ответ 6
 * @property string $answerPhoto7 Ответ 7
 * @property string $answerPhoto8 Ответ 8
 * @property string $right_answer Правильный ответ
 *
 * @property TournamentQuestion $id0
 */
class QuestionAnswerPhoto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'questionAnswerPhoto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['right_answer'], 'string'],

            [['id'], 'unique'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => TournamentQuestion::className(), 'targetAttribute' => ['id' => 'id']],

                        [['answerPhoto1'], 'required', 'when' => function($model) {
                return $model->answerPhoto1 == '';
            },'whenClient' => "function (attribute, value) {
                return $('input#questionanswerphoto-answerphoto1').attr('value') == undefined;
            }"],

                        [['answerPhoto2'], 'required', 'when' => function($model) {
                return $model->answerPhoto2 == '';
            },'whenClient' => "function (attribute, value) {
                return $('input#questionanswerphoto-answerphoto2').attr('value') == undefined;
            }"],

                        [['answerPhoto3'], 'required', 'when' => function($model) {
                return $model->answerPhoto3 == '';
            },'whenClient' => "function (attribute, value) {
                return $('input#questionanswerphoto-answerphoto3').attr('value') == undefined;
            }"],

                        [['answerPhoto4'], 'required', 'when' => function($model) {
                return $model->answerPhoto4 == '';
            },'whenClient' => "function (attribute, value) {
                return $('input#questionanswerphoto-answerphoto4').attr('value') == undefined;
            }"],

                        [['answerPhoto5'], 'required', 'when' => function($model) {
                return $model->answerPhoto5 == '';
            },'whenClient' => "function (attribute, value) {
                return $('input#questionanswerphoto-answerphoto5').attr('value') == undefined;
            }"],

                        [['answerPhoto6'], 'required', 'when' => function($model) {
                return $model->answerPhoto6 == '';
            },'whenClient' => "function (attribute, value) {
                return $('input#questionanswerphoto-answerphoto6').attr('value') == undefined;
            }"],

                        [['answerPhoto7'], 'required', 'when' => function($model) {
                return $model->answerPhoto7 == '';
            },'whenClient' => "function (attribute, value) {
                return $('input#questionanswerphoto-answerphoto7').attr('value') == undefined;
            }"],

                        [['answerPhoto8'], 'required', 'when' => function($model) {
                return $model->answerPhoto8 == '';
            },'whenClient' => "function (attribute, value) {
                return $('input#questionanswerphoto-answerphoto8').attr('value') == undefined;
            }"],

            [
                ['answerPhoto1', 'answerPhoto2', 'answerPhoto3', 'answerPhoto4', 'answerPhoto5', 'answerPhoto6', 'answerPhoto7', 'answerPhoto8'], 'file', 
                'extensions' => 'jpg, png, gif, jpeg', 
                'wrongExtension' => 'Только jpg, png, gif',
                'maxSize' => Yii::$app->params['max_filesize_img'],
                'minSize' => 5000, //5 кб
                'tooBig' => 'Максимальный файл 10мб',
                'tooSmall' => 'Минимальный файл - 5кб', 
                'skipOnEmpty' => true
            ],


        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'answerPhoto1' => 'Фото 1',
            'answerPhoto2' => 'Фото 2',
            'answerPhoto3' => 'Фото 3',
            'answerPhoto4' => 'Фото 4',
            'answerPhoto5' => 'Фото 5',
            'answerPhoto6' => 'Фото 6',
            'answerPhoto7' => 'Фото 7',
            'answerPhoto8' => 'Фото 8',
            'right_answer' => 'Правильный ответ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(TournamentQuestion::className(), ['id' => 'id']);
    }
}
