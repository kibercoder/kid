<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tournamentLinkQuestion".
 *
 * @property int $id_t id Турнира
 * @property int $id_q id Вопроса
 *
 * @property Tournament $t
 * @property TournamentQuestion $q
 */
class TournamentLinkQuestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tournamentLinkQuestion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_t', 'id_q'], 'required'],
            [['id_t', 'id_q'], 'integer'],
            [['id_t', 'id_q'], 'unique', 'targetAttribute' => ['id_t', 'id_q']],
            [['id_t'], 'exist', 'skipOnError' => true, 'targetClass' => Tournament::className(), 'targetAttribute' => ['id_t' => 'id_t']],
            [['id_q'], 'exist', 'skipOnError' => true, 'targetClass' => TournamentQuestion::className(), 'targetAttribute' => ['id_q' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_t' => 'id Турнира',
            'id_q' => 'id Вопроса',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getT()
    {
        return $this->hasOne(Tournament::className(), ['id_t' => 'id_t']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQ()
    {
        return $this->hasOne(TournamentQuestion::className(), ['id' => 'id_q']);
    }
}
