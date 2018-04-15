<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "friends".
 *
 * @property int $from_uid от кого
 * @property int $to_uid к кому
 * @property int $accept статус
 */
class Friend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'friend';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_uid', 'to_uid'], 'required'],
            [['from_uid', 'to_uid'], 'integer'],
            [['accept'], 'boolean'],
            [['from_uid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['from_uid' => 'id']],    
            [['from_uid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['from_uid' => 'id']],       
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'from_uid' => 'от кого',
            'to_uid' => 'к кому',
            'accept' => 'статус',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFrom()
    {
        return $this->hasOne(User::className(), ['id' => 'from_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTo()
    {
        return $this->hasOne(User::className(), ['id' => 'to_user_id']);
    }    
}
