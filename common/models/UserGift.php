<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "userGift".
 *
 * @property int $to_user_id
 * @property int $from_user_id
 * @property int $gift_id
 * @property string $created
 */
class UserGift extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'userGift';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['to_user_id', 'from_user_id', 'gift_id'], 'required'],
            [['to_user_id', 'from_user_id', 'gift_id'], 'integer'],
            [['created'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'to_user_id' => 'To User ID',
            'from_user_id' => 'From User ID',
            'gift_id' => 'Gift ID',
            'created' => 'Created',
        ];
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getGift()
    {
        return $this->hasOne(Gift::className(), ['id' => 'gift_id']);
    }   
}
