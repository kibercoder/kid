<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "questionAnswerString".
 *
 * @property int $id
 * @property string $answer1 Ответ 1
 * @property string $answer2 Ответ 2
 * @property string $answer3 Ответ 3
 * @property string $answer4 Ответ 4
 * @property string $right_answer Правильный ответ
 *
 * @property TournamentQuestion $id0
 */
class QuestionAnswerString extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'questionAnswerString';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'answer1', 'answer2', 'answer3', 'answer4', 'right_answer'], 'required'],
            [['id'], 'integer'],
            [['right_answer', 'photo'], 'string'],

            [['answer1', 'answer2', 'answer3', 'answer4'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => TournamentQuestion::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'answer1' => 'Ответ 1',
            'answer2' => 'Ответ 2',
            'answer3' => 'Ответ 3',
            'answer4' => 'Ответ 4',
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
