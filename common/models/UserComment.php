<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "userComment".
 *
 * @property int $id_c Комментарий
 * @property int $id_u Пользователь
 *
 * @property Comment $c
 * @property User $u
 */
class UserComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'userComment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_c', 'id_u'], 'required'],
            [['id_c', 'id_u'], 'integer'],
            [['id_c', 'id_u'], 'unique', 'targetAttribute' => ['id_c', 'id_u']],
            [['id_c'], 'exist', 'skipOnError' => true, 'targetClass' => Comment::className(), 'targetAttribute' => ['id_c' => 'id']],
            [['id_u'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_u' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_c' => 'Комментарий',
            'id_u' => 'Пользователь',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getC()
    {
        return $this->hasOne(Comment::className(), ['id' => 'id_c']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getU()
    {
        return $this->hasOne(User::className(), ['id' => 'id_u']);
    }
}
