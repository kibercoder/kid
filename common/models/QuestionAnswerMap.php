<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "questionAnswerMap".
 *
 * @property int $id id вопроса
 * @property int $id_map id Региона
 *
 * @property TournamentQuestion $id0
 * @property Map $map
 */
class QuestionAnswerMap extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'questionAnswerMap';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_map'], 'required'],
            [['id', 'id_map'], 'integer'],
            [['id_map'], 'required', 'message' => 'Вы не правильно указали страну'],

            [['id', 'id_map'], 'unique', 'targetAttribute' => ['id', 'id_map']],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => TournamentQuestion::className(), 'targetAttribute' => ['id' => 'id']],
            [['id_map'], 'exist', 'skipOnError' => true, 'targetClass' => Map::className(), 'targetAttribute' => ['id_map' => 'id_map']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id вопроса',
            'id_map' => 'id Региона',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(TournamentQuestion::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMap()
    {
        return $this->hasOne(Map::className(), ['id_map' => 'id_map']);
    }
}
