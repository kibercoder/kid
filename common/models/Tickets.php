<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tickets".
 *
 * @property int $id_t1 id Турнира 1
 * @property int $id_t2 id Турнира 2
 *
 * @property Tournament $t1
 * @property Tournament $t2
 */
class Tickets extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tickets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_t1', 'id_t2'], 'required'],
            [['id_t1', 'id_t2'], 'integer'],
            [['id_t1', 'id_t2'], 'unique', 'targetAttribute' => ['id_t1', 'id_t2']],
            [['id_t1'], 'exist', 'skipOnError' => true, 'targetClass' => Tournament::className(), 'targetAttribute' => ['id_t1' => 'id_t']],
            [['id_t2'], 'exist', 'skipOnError' => true, 'targetClass' => Tournament::className(), 'targetAttribute' => ['id_t2' => 'id_t']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_t1' => 'id Турнира 1',
            'id_t2' => 'id Турнира 2',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getT1()
    {
        return $this->hasOne(Tournament::className(), ['id_t' => 'id_t1']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getT2()
    {
        return $this->hasOne(Tournament::className(), ['id_t' => 'id_t2']);
    }
}
