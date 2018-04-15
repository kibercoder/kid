<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "userAvatar".
 *
 * @property int $id_a id Аватара
 * @property int $id_u id Пользователя
 *
 * @property Avatar $a
 * @property User $u
 */
class UserAvatar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'userAvatar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_a', 'id_u'], 'required'],
            [['id_a', 'id_u'], 'integer'],
            [['id_a', 'id_u'], 'unique', 'targetAttribute' => ['id_a', 'id_u']],
            [['id_a'], 'exist', 'skipOnError' => true, 'targetClass' => Avatar::className(), 'targetAttribute' => ['id_a' => 'id_avatar']],
            [['id_u'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_u' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_a' => 'id Аватара',
            'id_u' => 'id Пользователя',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getA()
    {
        return $this->hasOne(Avatar::className(), ['id_avatar' => 'id_a']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getU()
    {
        return $this->hasOne(User::className(), ['id' => 'id_u']);
    }
}
