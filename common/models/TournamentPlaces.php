<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tournamentPlaces".
 *
 * @property int $id_t id Турнира
 * @property int $place Место
 * @property int $value призовые
 *
 * @property Tournament $t
 */
class TournamentPlaces extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tournamentPlaces';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_t', 'place', 'value'], 'required'],
            [['id_t', 'place', 'value'], 'integer'],
            [['id_t', 'place'], 'unique', 'targetAttribute' => ['id_t', 'place']],
            [['id_t'], 'exist', 'skipOnError' => true, 'targetClass' => Tournament::className(), 'targetAttribute' => ['id_t' => 'id_t']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_t' => 'id Турнира',
            'place' => 'Место',
            'value' => 'призовые',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getT()
    {
        return $this->hasOne(Tournament::className(), ['id_t' => 'id_t']);
    }
}
