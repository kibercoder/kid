<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "settle".
 *
 * @property int $id
 * @property int $user_id идентификатор пользователя
 * @property string $name Название профессии
 */
class Settle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name'], 'required'],
            [['user_id'], 'integer'],
            [['name'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'идентификатор пользователя',
            'name' => 'Название профессии',
        ];
    }
}
