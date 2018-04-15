<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gift".
 *
 * @property int $id
 * @property string $url Ссылка на картинку
 * @property int $price Цена 
 * @property int $period Период показа
 */
class Gift extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gift';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'price'], 'required'],
            [['price', 'period'], 'integer'],
            [['url'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Ссылка на картинку',
            'price' => 'Цена ',
            'period' => 'Период показа',
        ];
    }
}
